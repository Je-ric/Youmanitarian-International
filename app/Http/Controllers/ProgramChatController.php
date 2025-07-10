<?php

namespace App\Http\Controllers;

use App\Events\NewChatMessage;
use App\Models\Program;
use App\Models\ProgramChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProgramChatController extends Controller
{
    /**
     * Display the list of all program chats.
     */
    public function gotoChatsList()
    {
        // Get programs where user is either a volunteer or coordinator
        $programs = Program::where(function($query) {
            $query->where('created_by', Auth::id())
                  ->orWhereHas('volunteers', function($q) {
                      $q->where('volunteers.user_id', Auth::id())
                        ->where('program_volunteers.status', 'approved');
                  });
        })->with(['volunteers', 'chats'])->get();

        return view('programs_chats.index', compact('programs'));
    }

    /**
     * Display the chat interface for a specific program.
     */
    public function gotoProgramChat(Program $program)
    {
        // Check if user can access the program's chat
        if (!$this->canAccessProgramChat($program)) {
            return redirect()->route('program.chats.index')
                           ->with('toast', [
                               'type' => 'error',
                               'message' => 'You do not have access to this program chat.'
                           ]);
        }

        // Get all programs for the sidebar
        $programs = Program::where(function($query) {
            $query->where('created_by', Auth::id())
                  ->orWhereHas('volunteers', function($q) {
                      $q->where('volunteers.user_id', Auth::id())
                        ->where('program_volunteers.status', 'approved');
                  });
        })->with(['volunteers', 'chats'])->get();

        // Get messages for the selected program
        $messages = $program->chats()
            ->with(['sender:id,name,profile_pic'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('programs_chats.index', compact('programs', 'program', 'messages'));
    }

    /**
     * Store a new message
     */
    public function storeChatMessage(Request $request, Program $program)
    {
        if (!$this->canAccessProgramChat($program)) {
            return response()->json([
                'success' => false,
                'error' => 'You do not have access to this program chat.'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'Message is required and must be less than 1000 characters.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $chat = $program->chats()->create([
                'sender_id' => Auth::id(),
                'message' => $request->message,
                'message_type' => 'regular'
            ]);

            // Load the sender relationship for broadcasting
            $chat->load('sender:id,name,profile_pic');

            // Broadcast the new message
            broadcast(new NewChatMessage($chat))->toOthers();
            
            Log::info('Message created and broadcasted successfully', [
                'chat_id' => $chat->id,
                'program_id' => $program->id,
                'sender_id' => Auth::id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Message sent successfully.',
                'chat' => $chat,
                'chat_html' => $this->generateMessageHtml($chat)
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to create chat message', [
                'program_id' => $program->id,
                'sender_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Failed to send message. Please try again.'
            ], 500);
        }
    }

    /**
     * Update a message
     */
    public function updateChatMessage(Request $request, Program $program, ProgramChat $chat)
    {
        // Verify the chat belongs to the correct program
        if ($chat->program_id !== $program->id) {
            return response()->json([
                'success' => false,
                'error' => 'Message not found in this program.'
            ], 404);
        }

        if ($chat->sender_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'error' => 'You can only edit your own messages.'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'Message is required and must be less than 1000 characters.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $chat->update([
                'message' => $request->message,
                'is_edited' => true,
                'edited_at' => now()
            ]);

            // Load the sender relationship for broadcasting
            $chat->load('sender:id,name,profile_pic');

            // Broadcast the updated message
            broadcast(new NewChatMessage($chat))->toOthers();

            Log::info('Message updated and broadcasted successfully', [
                'chat_id' => $chat->id,
                'program_id' => $program->id,
                'sender_id' => Auth::id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Message updated successfully.',
                'chat' => $chat,
                'chat_html' => $this->generateMessageHtml($chat)
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to update chat message', [
                'chat_id' => $chat->id,
                'program_id' => $program->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Failed to update message. Please try again.'
            ], 500);
        }
    }

    /**
     * Delete a message
     */
    public function deleteChatMessage(Program $program, ProgramChat $chat)
    {
        // Verify the chat belongs to the correct program
        if ($chat->program_id !== $program->id) {
            return response()->json([
                'success' => false,
                'error' => 'Message not found in this program.'
            ], 404);
        }

        if ($chat->sender_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'error' => 'You can only delete your own messages.'
            ], 403);
        }

        try {
            // Store the chat ID before deletion for broadcasting
            $chatId = $chat->id;
            $programId = $program->id;
            
            $chat->delete();

            // Broadcast the deleted message
            broadcast(new NewChatMessage((object)[
                'id' => $chatId,
                'is_deleted' => true,
                'program_id' => $programId
            ]))->toOthers();

            Log::info('Message deleted and broadcasted successfully', [
                'chat_id' => $chatId,
                'program_id' => $programId,
                'sender_id' => Auth::id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Message deleted successfully.',
                'chat_id' => $chatId
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to delete chat message', [
                'chat_id' => $chat->id,
                'program_id' => $program->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Failed to delete message. Please try again.'
            ], 500);
        }
    }

    /**
     * Generate HTML for a message (for AJAX responses)
     */
    private function generateMessageHtml($chat)
    {
        $isOwnMessage = $chat->sender_id === Auth::id();
        $messageClass = $isOwnMessage ? 'flex-row-reverse' : '';
        $contentClass = $isOwnMessage ? 'text-right' : '';
        $headerClass = $isOwnMessage ? 'justify-end' : 'justify-start';
        $bubbleClass = $isOwnMessage ? 'bg-[#ffb51b] text-[#1a2235]' : 'bg-gray-100 text-gray-700';
        
        $editButton = $isOwnMessage ? "
            <div class='flex items-center gap-2 mt-1 justify-end'>
                <button onclick='editMessage({$chat->id}, \"{$chat->message}\")' 
                        class='text-xs text-gray-500 hover:text-gray-700'>
                    <i class='bx bx-edit'></i> Edit
                </button>
                <button onclick='deleteMessage({$chat->id})' 
                        class='text-xs text-red-500 hover:text-red-700'>
                    <i class='bx bx-trash'></i> Delete
                </button>
            </div>
        " : '';

        $editedBadge = $chat->is_edited ? "<span class='text-xs text-gray-500 mt-1 block'>(edited)</span>" : '';

        $profilePic = $chat->sender->profile_pic ? $chat->sender->profile_pic : '/images/default-avatar.png';
        
        return "
            <div class='flex gap-3 {$messageClass}' data-message-id='{$chat->id}'>
                <div class='flex-shrink-0'>
                    <img src='{$profilePic}' 
                         alt='{$chat->sender->name}'
                         class='w-10 h-10 rounded-full'>
                </div>
                <div class='flex-1 {$contentClass}'>
                    <div class='flex items-center gap-2 {$headerClass}'>
                        <span class='font-medium text-[#1a2235]'>{$chat->sender->name}</span>
                        <span class='text-sm text-gray-500'>{$chat->created_at->diffForHumans()}</span>
                    </div>
                    <div class='mt-1 p-3 rounded-lg {$bubbleClass}'>
                        <p class='whitespace-pre-wrap'>{$chat->message}</p>
                        {$editedBadge}
                    </div>
                    {$editButton}
                </div>
            </div>
        ";
    }

    /**
     * Check if user can access program chat
     */
    private function canAccessProgramChat(Program $program)
    {
        return $program->created_by === Auth::id() || 
               $program->volunteers()
                   ->where('volunteers.user_id', Auth::id())
                   ->where('program_volunteers.status', 'approved')
                   ->exists();
    }
} 