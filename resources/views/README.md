# Programs & Volunteers Management System

This documentation covers the views for managing humanitarian programs and volunteers in the YouManitarian International platform, located in `resources/views/programs`, `resources/views/programs_volunteers`, and `resources/views/volunteers`.

## Directory Structure

```
views/
├── programs/                  # General program listing and creation
├── programs_volunteers/       # Managing volunteers within a specific program
└── volunteers/                # Global volunteer application and list management
```

---

## Key Features & Rules

### 1. Global Program Management (`/programs`)

-   **Only Admins and Program Coordinators can create new programs.**
-   Tabs and program lists are role-based:
    -   Volunteers see "All Programs" and "Joined Programs" tabs.
    -   Coordinators/Admins see "All Programs" and "My Programs" tabs.
-   **Program creators can delete only their own programs.**
-   All users can view program details.
-   **Volunteer Participation Rules:**
    -   Volunteers can **join** a program only if:
        -   The program is not full and is not already done.
        -   They are not already joined.
        -   Their global volunteer application is approved.
    -   Volunteers can **leave** a program only if:
        -   The program is still in "incoming" status (has not started).
        -   They have no assigned tasks in that program.

### 2. Program-Specific Volunteer Management (`/programs/{id}/manage`)

This view is for program coordinators to manage the volunteers and tasks for a specific program they created.

-   **Tabs include:** Volunteers, Overview, Tasks & Assignments, Program Settings, and Feedbacks.
-   **Coordinators can:**
    -   View lists of approved and pending volunteers for their program.
    -   Approve or deny pending volunteer requests for their program.
    -   Approve or reject uploaded attendance proofs from volunteers.
    -   Create, assign, and manage tasks for volunteers.
    -   Manually enter attendance for volunteers who missed clocking in/out.
    -   View all feedback submitted for the program.
    -   Edit their program's details and settings.

### 3. Global Volunteer Management (`/volunteers`)

This section is for Admins/Coordinators to manage the central list of all volunteers and their applications to join the organization.

-   **Submitting an Application:**
    -   Any registered user can submit a volunteer application via the form.
    -   The application includes details on motivation, skills, availability, and consent.
-   **Application Processing (`VolunteerApprovalController`):**
    -   Admins/Coordinators can view all pending volunteer applications.
    -   They can **Approve** or **Deny** applications.
    -   Denied applications can be **restored** to pending status.
-   **Approved Volunteers:**
    -   Once approved, a volunteer can join programs.
    -   Admins can invite approved volunteers to become official **Members** of the organization.

### 4. Participant Rules (Attendance, Tasks, and Feedback)

-   **Attendance:**
    -   Volunteers can only clock in/out if the program has started and they have joined it.
    -   Clock in/out is allowed only once per program.
    -   Attendance proof can only be uploaded after clocking in.
    -   If a volunteer misses clocking in/out, they must contact their coordinator for manual entry.
-   **Tasks:**
    -   Volunteers can update their own task status to "pending" or "in progress".
    -   Volunteers cannot mark their own tasks as "completed"; this must be done by a coordinator.
-   **Feedback:**
    -   Volunteers and guests can only submit feedback/ratings after a program has ended.

### 5. UI/UX Feedback (Toasts and Alerts)

-   The system uses toasts and alerts to provide clear feedback for all major actions, such as:
    -   Creating, updating, or deleting programs and tasks.
    -   Joining or leaving a program.
    -   Approving, denying, or managing volunteers.
    -   All successful actions and error conditions.
