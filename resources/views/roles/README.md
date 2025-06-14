# Roles Management System

This directory contains the views for managing user roles and permissions in the YouManitarian International platform.

## Directory Structure

```
roles/
├── index.blade.php           # Main roles management page
└── partials/
    ├── assign_rolesModal.blade.php  # Modal for assigning roles to users
    └── overview.blade.php           # Role statistics and distribution overview
```

## Key Features

1. **Role Types**
   - Admin
   - Content Manager
   - Program Coordinator
   - Financial Coordinator
   - Member (Different)
   - Volunteer (Base role)

2. **Role Assignment Rules**
   - Every user must have the Volunteer role
   - Volunteer role cannot be removed
   - Volunteer role is automatically assigned after applications been approved. 
   - Multiple roles can be assigned to a user
   - Changes are saved only after clicking "Save Changes"
   - Canceling the modal discards all changes
