# Understanding Models in Laravel

## What is a Model?
A **model** in Laravel represents a single table in your database and provides an easy way to interact with that table's data using PHP code. Each model is a PHP class that extends Laravel's `Model` class.

- Think of a model as a blueprint for a type of data (like User, Program, or Donation).
- Each instance of a model represents a single row in the corresponding database table.

## Why Use Models?
- **Separation of Concerns:** Models keep your business/data logic separate from your controllers and views.
- **Eloquent ORM:** Laravel models use Eloquent, which lets you work with your database using expressive, readable PHP instead of raw SQL.
- **Relationships:** Models make it easy to define and use relationships between different types of data (e.g., a User has many Donations).

## How Models Relate to the Database
- Each model typically maps to a table (e.g., the `User` model maps to the `users` table).
- The model's properties and methods let you create, read, update, and delete records in that table.

## What is `$fillable`?
- The `$fillable` property is an array that lists which fields can be mass-assigned (set all at once, e.g., from a form).
- This helps protect your app from mass-assignment vulnerabilities.

```php
class User extends Model {
    protected $fillable = ['name', 'email', 'password'];
}
```

## What are Relationships?
Relationships let you connect different models together, reflecting how your data is structured in the real world.

- **hasMany:** One model has many of another (e.g., a User has many Donations)
- **belongsTo:** One model belongs to another (e.g., a Donation belongs to a User)
- **belongsToMany:** Many-to-many (e.g., a User can have many Roles, and a Role can have many Users)

Example:
```php
// In User.php
public function donations() {
    return $this->hasMany(Donation::class);
}

// In Donation.php
public function user() {
    return $this->belongsTo(User::class);
}
```

## Types of Eloquent Relationships

### 1. One To One
- A model has exactly one of another model.
- Example: A User has one Profile.

```php
// User.php
public function profile() {
    return $this->hasOne(Profile::class);
}

// Profile.php
public function user() {
    return $this->belongsTo(User::class);
}
```

### 2. One To Many
- A model has many of another model.
- Example: A User has many Posts.

```php
// User.php
public function posts() {
    return $this->hasMany(Post::class);
}

// Post.php
public function user() {
    return $this->belongsTo(User::class);
}
```

### 3. Many To Many
- Both models can have many of each other (uses a pivot table).
- Example: A User belongs to many Roles, and a Role belongs to many Users.

```php
// User.php
public function roles() {
    return $this->belongsToMany(Role::class);
}

// Role.php
public function users() {
    return $this->belongsToMany(User::class);
}
```

### 4. Has One Through
- A model has one of another model through a third model.
- Example: A Supplier has one Account through a User.

```php
// Supplier.php
public function account() {
    return $this->hasOneThrough(Account::class, User::class);
}
```

### 5. Has Many Through
- A model has many of another model through a third model.
- Example: A Country has many Posts through Users.

```php
// Country.php
public function posts() {
    return $this->hasManyThrough(Post::class, User::class);
}
```

### 6. One To One (Polymorphic)
- A model can belong to more than one other model on a single association.
- Example: An Image can belong to either a Post or a User.

```php
// Image.php
public function imageable() {
    return $this->morphTo();
}

// Post.php
public function image() {
    return $this->morphOne(Image::class, 'imageable');
}

// User.php
public function image() {
    return $this->morphOne(Image::class, 'imageable');
}
```

### 7. One To Many (Polymorphic)
- A model can have many of another model, and that model can belong to different types.
- Example: A Post can have many Comments, and a Video can have many Comments.

```php
// Comment.php
public function commentable() {
    return $this->morphTo();
}

// Post.php
public function comments() {
    return $this->morphMany(Comment::class, 'commentable');
}

// Video.php
public function comments() {
    return $this->morphMany(Comment::class, 'commentable');
}
```

### 8. Many To Many (Polymorphic)
- A model can belong to many other models, and vice versa, across different types.
- Example: Tags can be attached to both Posts and Videos.

```php
// Tag.php
public function posts() {
    return $this->morphedByMany(Post::class, 'taggable');
}

public function videos() {
    return $this->morphedByMany(Video::class, 'taggable');
}

// Post.php
public function tags() {
    return $this->morphToMany(Tag::class, 'taggable');
}

// Video.php
public function tags() {
    return $this->morphToMany(Tag::class, 'taggable');
}
```

For more details and advanced usage, see the [Laravel Eloquent Relationships documentation](https://laravel.com/docs/eloquent-relationships).

## How to Use Models
You use models in controllers, views, and other parts of your app to interact with your data.

### Creating a Record
```php
$user = User::create([
    'name' => 'Jeric',
    'email' => 'jeric@example.com',
    'password' => bcrypt('secret'),
]);
```

### Querying Data
```php
$users = User::where('active', true)->get();
$firstUser = User::first();
```

### Updating Data
```php
$user = User::find(1);
$user->email = 'new@email.com';
$user->save();
```

### Using Relationships
```php
// Get all donations for a user
$donations = $user->donations;

// Get the user who made a donation
$donor = $donation->user;
```

### Eager Loading (for performance)
```php
$users = User::with('donations')->get();
```

## Summary
- Models are the main way you interact with your database in Laravel.
- They make your code cleaner, safer, and easier to understand.
- Use relationships to connect your data.
- Use `$fillable` to protect your app.
- Use Eloquent methods to create, read, update, and delete data easily.

For more, see the [Laravel Eloquent documentation](https://laravel.com/docs/eloquent). 