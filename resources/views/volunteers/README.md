# Volunteers Management System

This directory contains the views for managing volunteers in the YouManitarian International platform.

## Directory Structure

```
volunteers/
├── index.blade.php           # Main volunteers listing and management page
├── form.blade.php            # Volunteer application form
├── viewUser_details.blade.php # Detailed volunteer profile view
└── partials/
    └── offCanvas.blade.php   # Side panel for additional volunteer information
```

## Key Features

1. **Volunteer Types**
   - New Applicants
   - Active Volunteers
   - Inactive Volunteers
   - Rejected Applicants

2. **Volunteer Management Rules**
   - All new volunteers must complete the application form
   - Applications must be reviewed and approved by Admin / Program Coordinators
   - Volunteer role is automatically assigned after application approval
   - Changes are saved only after confirmation
   - Canceling any operation discards all changes

3. **Application Process**
   - Fill out the volunteer application form
   - Application is reviewed by Admin / Program Coordinators
   - Upon approval, volunteer role is automatically assigned and can now join to programs as volunteers
   - Rejected applications can be (unknown for now)