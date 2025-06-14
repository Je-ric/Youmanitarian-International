# Programs Management System

This directory contains the views for managing humanitarian programs in the YouManitarian International platform.

## Directory Structure

```
programs/
├── index.blade.php              # Main programs listing page
├── create.blade.php             # Program creation page
├── edit.blade.php               # Program editing page
├── _form.blade.php              # Shared program form component
├── attendance.blade.php         # Program attendance management
├── partials/
│   ├── programs-table.blade.php     # Programs listing table
│   └── attendanceReminders.blade.php # Attendance reminder system
└── modals/
    ├── program-modal.blade.php      # Program details modal
    ├── feedbackModal.blade.php      # Program feedback interface
    └── proofModal.blade.php         # Program proof/documentation modal
```

## Key Features

1. **Program Types**
   - Active Programs
   - Upcoming Programs
   - Completed Programs
   - Cancelled Programs

2. **Program Management Rules**
   - Programs must be created by Admin / Program Coordinators
   - Each program requires a coordinator
   - Programs must have defined start and end dates
   - Programs must have a maximum volunteer capacity
   - Program status can be updated by coordinators
   - Program details can be modified before start date
   - All changes are logged for tracking

3. **Program Creation Process**
   - Fill out program details form
   - Set program schedule and location
   - Define volunteer requirements
   - Set program objectives and goals
   - Assign program coordinator
   - Set program capacity
   - Submit for approval (if required)
   - Program becomes visible to volunteers

4. **Attendance Management**
   - Track volunteer attendance
   - Send attendance reminders
   - Record late arrivals
   - Document absences
   - Generate attendance reports
   - Monitor participation rates

5. **Program Documentation**
   - Program objectives and goals
   - Required volunteer skills
   - Program schedule
   - Location details
   - Required documents
   - Program feedback
   - Proof of completion
   - Impact assessment 