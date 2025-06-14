# Programs Volunteers Management System

This directory contains the views for managing volunteers within programs in the YouManitarian International platform.

## Directory Structure

```
programs_volunteers/
├── program-volunteers.blade.php    # Main program volunteers management page
├── partials/
│   ├── programTasks.blade.php      # Program tasks and assignments
│   ├── programDetails.blade.php    # Program information and details
│   ├── viewFeedback.blade.php      # Volunteer feedback viewing interface
│   ├── volunteerLists.blade.php    # List of volunteers in the program
│   └── feedbackItem.blade.php      # Individual feedback item component
└── modals/
    ├── attendanceApproval.blade.php    # Attendance approval interface
    └── manualAttendanceModal.blade.php # Manual attendance entry modal
```

## Key Features

1. **Program Volunteer Types**
   - Active Program Volunteers
   - Task-Assigned Volunteers
   - Attendance-Tracked Volunteers
   - Feedback-Providing Volunteers

2. **Program Volunteer Management Rules**
   - Only approved volunteers can join programs
   - Program Coordinators manage volunteer assignments
   - Attendance must be tracked for each program session
   - Feedback can be provided by both volunteers and coordinators
   - Changes to assignments require coordinator approval
   - Attendance changes require coordinator approval
   - All modifications are logged for tracking

3. **Program Assignment Process**
   - Volunteers must be approved for the program
   - Program Coordinators assign tasks to volunteers
   - Volunteers can view their assigned tasks
   - Attendance is tracked for each program session
   - Feedback can be submitted after program completion
   - Program status is updated based on volunteer participation

4. **Attendance Management**
   - Automatic attendance tracking
   - Manual attendance entry option
   - Attendance approval workflow
   - Attendance history tracking
   - Absence reporting system
   - Late arrival tracking

5. **Feedback System**
   - Program feedback collection
   - Volunteer performance feedback
   - Coordinator feedback on volunteers
   - Feedback history tracking
   - Feedback response system
   - Feedback analytics 