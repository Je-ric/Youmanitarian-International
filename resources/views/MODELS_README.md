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