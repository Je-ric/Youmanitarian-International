# Database Seeders

This directory contains seeders for populating the database with test data.

## Available Seeders

### ProgramVolunteerSeeder
Creates programs and assigns volunteers to them **without** creating attendance records.

**What it creates:**
- 7 programs (2 past, 2 current/recent, 3 future)
- Assigns volunteers to each program via the `program_volunteers` table
- No attendance records are created

**Programs created:**
- **Past Programs:**
  - Community Service Day (12 volunteers)
  - Educational Workshop Series (8 volunteers)
- **Current/Recent Programs:**
  - Health Awareness Campaign (15 volunteers)
  - Food Drive Initiative (20 volunteers)
- **Future Programs:**
  - Environmental Conservation Project (18 volunteers)
  - Cultural Festival Celebration (25 volunteers)
  - Youth Mentorship Program (10 volunteers)

### ProgramSeeder (Original)
Creates programs, assigns volunteers, AND creates attendance records with various scenarios.

### Other Seeders
- `RoleSeeder`: Creates user roles
- `UserSeeder`: Creates users and volunteers
- `VolunteerToMemberSeeder`: Converts volunteers to members

## Usage

### Run all seeders:
```bash
php artisan db:seed
```

### Run specific seeder:
```bash
php artisan db:seed --class=ProgramVolunteerSeeder
```

### Run only program and volunteer seeder (without attendance):
```bash
php artisan db:seed --class=ProgramVolunteerSeeder
```

### Run original seeder with attendance records:
```bash
php artisan db:seed --class=ProgramSeeder
```

## Dependencies

The `ProgramVolunteerSeeder` requires:
- Users to exist (run `UserSeeder` first)
- Volunteers to exist (created by `UserSeeder`)
- A Program Coordinator user (created by `RoleSeeder` and `UserSeeder`)

## Notes

- The seeder randomly selects volunteers for each program
- All volunteers are assigned with 'approved' status
- No attendance records are created, only program-volunteer relationships
- Programs have realistic dates, times, and locations 
