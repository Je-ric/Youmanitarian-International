# Understanding Controllers in Laravel

## What is a Controller?
A **controller** in Laravel handles incoming HTTP requests and returns responses. It acts as the "traffic cop" between your routes and your application logic.

- Controllers contain the logic that processes user requests
- They coordinate between models (data) and views (presentation)
- They follow the MVC (Model-View-Controller) pattern

## Why Use Controllers?
- **Separation of Concerns:** Keep request handling logic separate from routes and views
- **Reusability:** Controller methods can be reused across different routes
- **Organization:** Group related functionality together
- **Maintainability:** Easier to test and maintain business logic

## How Controllers Work
1. **Route receives request** → Points to a controller method
2. **Controller processes request** → Uses models to get/manipulate data
3. **Controller returns response** → View, JSON, redirect, etc.

## Basic Controller Structure

```php
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Controller methods go here
}
```

## Common HTTP Methods & Controller Actions

### GET Requests (Reading Data)
```php
public function index()
{
    // Display a list of resources
    $users = User::all();
    return view('users.index', compact('users'));
}

public function show($id)
{
    // Display a specific resource
    $user = User::findOrFail($id);
    return view('users.show', compact('user'));
}

public function create()
{
    // Show form to create new resource
    return view('users.create');
}

public function edit($id)
{
    // Show form to edit existing resource
    $user = User::findOrFail($id);
    return view('users.edit', compact('user'));
}
```

### POST Requests (Creating Data)
```php
public function store(Request $request)
{
    // Validate and store new resource
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8'
    ]);

    User::create($validated);
    return redirect()->route('users.index')->with('success', 'User created!');
}
```

### PUT/PATCH Requests (Updating Data)
```php
public function update(Request $request, $id)
{
    // Validate and update existing resource
    $user = User::findOrFail($id);
    
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id
    ]);

    $user->update($validated);
    return redirect()->route('users.show', $user)->with('success', 'Updated!');
}
```

### DELETE Requests (Removing Data)
```php
public function destroy($id)
{
    // Delete a resource
    $user = User::findOrFail($id);
    $user->delete();
    
    return redirect()->route('users.index')->with('success', 'User deleted!');
}
```

## Resource Controllers
Laravel provides a quick way to create controllers with all CRUD operations:

```bash
php artisan make:controller UserController --resource
```

This creates a controller with these methods:
- `index()` - Display all
- `create()` - Show create form
- `store()` - Save new
- `show()` - Display one
- `edit()` - Show edit form
- `update()` - Save changes
- `destroy()` - Delete

## Controller Patterns & Best Practices

### 1. Validation
Always validate incoming data:

```php
public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'status' => 'required|in:draft,published'
    ]);

    // Use validated data
    Post::create($validated);
}
```

### 2. Authorization
Check if user can perform action:

```php
public function update(Request $request, Post $post)
{
    // Check if user owns this post
    if ($post->user_id !== auth()->id()) {
        abort(403, 'Unauthorized');
    }

    // Or use Laravel's authorization
    $this->authorize('update', $post);
}
```

### 3. Dependency Injection
Inject dependencies through constructor:

```php
class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index()
    {
        $posts = $this->postService->getAllPosts();
        return view('posts.index', compact('posts'));
    }
}
```

### 4. Response Types
Return appropriate responses:

```php
// Return view
return view('users.index', compact('users'));

// Return JSON
return response()->json(['users' => $users]);

// Redirect
return redirect()->route('users.index');

// Redirect with data
return redirect()->back()->with('success', 'Saved!');

// Return with status
return response('Created', 201);
```

## Middleware in Controllers
Apply middleware to controller methods:

```php
class UserController extends Controller
{
    public function __construct()
    {
        // Apply to all methods
        $this->middleware('auth');
        
        // Apply to specific methods
        $this->middleware('admin')->only(['destroy']);
        $this->middleware('guest')->except(['index', 'show']);
    }
}
```

## Common Controller Methods

### Pagination
```php
public function index()
{
    $users = User::paginate(15);
    return view('users.index', compact('users'));
}
```

### Search & Filtering
```php
public function index(Request $request)
{
    $query = User::query();
    
    if ($request->has('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }
    
    $users = $query->paginate(15);
    return view('users.index', compact('users'));
}
```

### File Uploads
```php
public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required',
        'avatar' => 'image|mimes:jpeg,png,jpg|max:2048'
    ]);

    if ($request->hasFile('avatar')) {
        $path = $request->file('avatar')->store('avatars', 'public');
        $validated['avatar'] = $path;
    }

    User::create($validated);
}
```

## Error Handling
Handle errors gracefully:

```php
public function show($id)
{
    try {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    } catch (ModelNotFoundException $e) {
        return redirect()->route('users.index')->with('error', 'User not found');
    }
}
```

## Summary
- Controllers handle HTTP requests and return responses
- Use resource controllers for CRUD operations
- Always validate incoming data
- Apply authorization where needed
- Return appropriate response types
- Use middleware for authentication/authorization
- Handle errors gracefully

For more details, see the [Laravel Controllers documentation](https://laravel.com/docs/controllers). 