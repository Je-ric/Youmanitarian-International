# Programs & Volunteers Management System

This documentation covers the views for managing humanitarian programs, volunteers, members, roles, and finances in the YouManitarian International platform, located in `resources/views/programs`, `resources/views/programs_volunteers`, `resources/views/volunteers`, `resources/views/member`, `resources/views/roles`, and `resources/views/finance`.

## Directory Structure

```
views/
├── programs/                  # General program listing and creation
├── programs_volunteers/       # Managing volunteers within a specific program
├── volunteers/                # Global volunteer application and list management
├── member/                    # Member management and organization membership
├── roles/                     # User roles and permissions management
└── finance/                   # Financial management (donations and membership payments)
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
        -   They are not already joined (common sense  HAHAHAHA).
        -   Their volunteer application is approved.
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

-   **Tabs include:** Overview, Applications, Denied, and Approved.
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

### 4. Member Management (`/member`)

This section manages official organization membership and member types.

-   **Tabs include:** Overview, Full-Pledge, Honorary, and Pending Invitations.
-   **Member Types:**
    -   **Full-Pledge Members:** Active volunteers that invited because of more than a year service.
    -   **Honorary Members:** Special recognition officials or professionals that didnt need more than a year service.
    -   **Pending Invitations:** Volunteers who have been invited to become members.
-   **Member Invitation Process:**
    -   Admins can invite approved volunteers to become members.
    -   Invitations are sent via email and notification to the account with membership details.
    -   Members can be categorized as Full-Pledge or Honorary based on their contribution level.

### 5. Role Management (`/roles`)

This section manages user roles and permissions throughout the platform.

-   **Role Types:**
    -   Admin: Full system access and control.
    -   Content Manager: Manages content creation and publication.
    -   Program Coordinator: Creates and manages programs.
    -   Financial Coordinator: Manages financial operations.
    -   Member: Different from volunteer, has organizational privileges.
    -   Volunteer: Base role for all approved volunteers.
-   **Role Assignment Rules:**
    -   Every user must have the Volunteer role. (not necessarily all)
    -   Volunteer role cannot be removed. (I mean, Admin can)
    -   Volunteer role is automatically assigned after applications are approved.
    -   Multiple roles can be assigned to a user.
    -   Changes are saved only after clicking "Save Changes".
    -   Canceling the modal discards all changes.

### 6. Financial Management (`/finance`)

This section manages all financial operations including donations and membership payments.

-   **Donations Management (`/finance/donations`):**
    -   **Tabs include:** Overview and Donations.
    -   Admins can add new donations with donor details, amounts, and payment methods.
    -   View all donations with status tracking (Pending/Confirmed). (Status are just indicator if really received or not)
    -   Confirm pending donations.
    -   Track donation summary and financial overview.
-   **Membership Payments (`/finance/membership_payments`):**
    -   Manage membership payment tracking and processing.
    -   Handle payment reminders and status updates.
    -   Track payment history and financial records.

### 7. Participant Rules (Attendance, Tasks, and Feedback)

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

### 8. UI/UX Feedback (Toasts and Alerts)

-   The system uses toasts and alerts to provide clear feedback for all major actions, such as:
    -   Creating, updating, or deleting programs and tasks.
    -   Joining or leaving a program.
    -   Approving, denying, or managing volunteers.
    -   Role assignments and permission changes.
    -   Financial transactions and payment processing.
    -   Member invitations and status updates.
    -   All successful actions and error conditions.
