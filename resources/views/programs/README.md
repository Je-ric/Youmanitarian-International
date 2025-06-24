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
   1. All Programs
   2. Joined Programs 
   3. My Programs

2. **Program Management Rules**
   - Only Admins and Program Coordinators can create new programs.
   - Volunteers see "All Programs" and "Joined Programs" tabs.
   - Coordinators/Admins see "All Programs" and "My Programs" tabs.
   - Only the program creator (coordinator) can manage volunteers and delete their own programs.
   - All users can view program details button.

3. **Volunteer Participation Rules**
   - Volunteers can join a program only if:
     - The program is not full.
     - The program is not already done.
     - They are not already joined. (Duh)
     - Their volunteer application is approved.
   - Volunteers can leave a program only if:
     - The program is still in "incoming" status (not started yet).
     - They have no assigned tasks in that program.

4. **Attendance and Task Rules**
   - Volunteers can only clock in/out for attendance if:
     - The program has started.
     - They are assigned to the program.
   - Volunteers can only clock in once and clock out once per program.
   - After clocking in, the clock-in button is disabled.
   - After clocking out, the clock-out button is disabled.
   - Attendance is only accessible after the program has started and is not available after the program is done.
   - Volunteers can only upload attendance proof after clocking in.
   - Volunteers can only submit feedback/rating after the program has ended. (Same for guests)
   - If a volunteer misses clocking in/out, only the coordinator can manually add attendance.

5. **Task Assignment Rules**
   - Only coordinators can mark a volunteer's task as "completed".
   - Volunteers can set their task assignment status to "pending" or "in progress", but not "completed".

6. **UI/UX Feedback and Restrictions**
   - Toasts and alerts are used throughout the system to provide feedback for user actions.
   - Users will see toast notifications or alerts when:
     - A program is created, updated, or deleted.
     - A volunteer joins or leaves a program.
     - A volunteer tries to join a full or finished program.
     - A volunteer tries to leave but has assigned tasks or the program is not incoming.
     - Attendance actions (clock in/out, upload proof) are performed or restricted.
     - Task assignment status is updated.
     - Any error, restriction, or important information needs to be communicated (e.g., not assigned to a program, duplicate join, missing attendance, etc.).

7. **Other Reminders**
   - Attendance is official documentation and is used for recognizing volunteer contributions.
   - If you missed clocking in/out, contact your program coordinator for manual attendance entry.
