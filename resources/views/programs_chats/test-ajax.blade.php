@extends('layouts.sidebar_final')

@section('content')
<div class="mx-auto px-4 py-6 max-w-4xl">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">jQuery AJAX Chat Test</h1>

        <!-- Test Message Form -->
        <div class="mb-8 p-4 bg-gray-50 rounded-lg">
            <h3 class="text-lg font-semibold mb-4">Test Message Sending</h3>
            <form id="testMessageForm" class="space-y-4">
                @csrf
                <div>
                    <label for="testMessage" class="block text-sm font-medium text-gray-700 mb-2">Message:</label>
                    <input type="text" id="testMessage" name="message"
                           class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Enter test message...">
                </div>
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500">
                    Send Test Message
                </button>
            </form>
        </div>

        <!-- Test Results -->
        <div class="mb-8 p-4 bg-gray-50 rounded-lg">
            <h3 class="text-lg font-semibold mb-4">Test Results</h3>
            <div id="testResults" class="space-y-2">
                <p class="text-gray-600">No tests run yet...</p>
            </div>
        </div>

        <!-- AJAX Status -->
        <div class="mb-8 p-4 bg-gray-50 rounded-lg">
            <h3 class="text-lg font-semibold mb-4">AJAX Status</h3>
            <div id="ajaxStatus" class="space-y-2">
                <p class="text-gray-600">Ready to test...</p>
            </div>
        </div>

        <!-- jQuery Test -->
        <div class="mb-8 p-4 bg-gray-50 rounded-lg">
            <h3 class="text-lg font-semibold mb-4">jQuery Test</h3>
            <button id="jqueryTest"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:ring-2 focus:ring-green-500">
                Test jQuery
            </button>
            <div id="jqueryResult" class="mt-2 text-gray-600"></div>
        </div>
    </div>
</div>

@push('scripts')
<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script>
$(document).ready(function() {
    console.log('🚀 jQuery loaded successfully!');

    // Test jQuery functionality
    $('#jqueryTest').on('click', function() {
        $('#jqueryResult').html('<span class="text-green-600">✅ jQuery is working! Version: ' + $.fn.jquery + '</span>');
    });

    // Test message form
    $('#testMessageForm').on('submit', function(e) {
        e.preventDefault();

        const message = $('#testMessage').val().trim();
        if (!message) {
            showResult('❌ Please enter a message', 'error');
            return;
        }

        showResult('🔄 Sending test message...', 'info');
        updateAjaxStatus('🔄 Processing...', 'info');

        // Simulate AJAX request
        $.ajax({
            url: '{{ route("program.chats.store", isset($program) ? $program : 1) }}',
            method: 'POST',
            data: {
                message: message,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    showResult('✅ Message sent successfully!', 'success');
                    updateAjaxStatus('✅ Success!', 'success');
                    $('#testMessage').val('');
                } else {
                    showResult('❌ ' + (response.error || 'Failed to send message'), 'error');
                    updateAjaxStatus('❌ Failed', 'error');
                }
            },
            error: function(xhr, status, error) {
                let errorMsg = 'Network error occurred';
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    errorMsg = xhr.responseJSON.error;
                }
                showResult('❌ ' + errorMsg, 'error');
                updateAjaxStatus('❌ Error: ' + status, 'error');
            }
        });
    });

    function showResult(message, type) {
        const colors = {
            success: 'text-green-600',
            error: 'text-red-600',
            info: 'text-blue-600'
        };

        $('#testResults').html(`
            <p class="${colors[type] || colors.info}">
                ${new Date().toLocaleTimeString()} - ${message}
            </p>
        `);
    }

    function updateAjaxStatus(message, type) {
        const colors = {
            success: 'text-green-600',
            error: 'text-red-600',
            info: 'text-blue-600'
        };

        $('#ajaxStatus').html(`
            <p class="${colors[type] || colors.info}">
                ${new Date().toLocaleTimeString()} - ${message}
            </p>
        `);
    }

    // Test CSRF token
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    if (csrfToken) {
        console.log('✅ CSRF token found:', csrfToken.substring(0, 20) + '...');
    } else {
        console.log('❌ CSRF token not found!');
    }
});
</script>
@endpush

@endsection
