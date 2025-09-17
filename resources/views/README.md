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
├── consultation/              # One‑to‑one consultation chats and hours management
├── programs_chats/            # Program group chat UI
├── program_requests/          # Public program requests
├── content/                   # CMS (create/edit/preview) and dynamic content
└── content/dynamic/           # Team members and other dynamic pages
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
    -   Volunteer profile supports profile photo upload and consolidated history.

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
    -   Invitation notifications are now pinned and accessible in Notifications. Accept/Decline flows update membership and roles accordingly.

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

### 6. Content Management (`/content`)

This section manages all site content, articles, and media. Both Content Managers and Program Coordinators can create and manage content, but only Content Managers can approve and publish content created by Program Coordinators.

-   **Tabs include:**
    -   My Content: Content created by the logged-in user. 
    -   Published: All published content.
    -   Drafts: User's drafts.
    -   Archived: User's archived content.
    -   Rejected/Needs Revision: User's content that was rejected or needs revision.
    -   Needs Approval: (Visible only to Content Managers) Content from Program Coordinators pending approval.
    -   Program Coordinators see Submitted and Needs Revision.
    -   Managers/Admins see My Content, Published, Archived, and Needs Approval.
-   **Role Permissions:**
    -   **Content Manager:**
        -   Can create, edit, publish, archive, and approve content.
        -   Can approve content created by Program Coordinators.
        -   Can publish their own content directly.
    -   **Program Coordinator:**
        -   Can create and edit content.
        -   Content they create requires approval from a Content Manager before being published (unless they also have the Content Manager role, in which case they can choose to publish directly or submit for approval).
        -   Cannot approve or archive content.
-   **Approval Workflow:**
    -   Content created by Program Coordinators is saved as a draft and marked as pending approval.
    -   Content Managers can view all pending content in the "Needs Approval" tab and approve it for publication.
    -   If a user has both roles, they can choose to publish directly or submit for approval when creating content.
-   **Other Features:**
    -   All users can view published content.
    -   Only the creator or a Content Manager can edit or update content.
    -   Archived and rejected content is accessible in their respective tabs for reference or revision.
    -   Overview/Create-Edit/Preview tabs in Content default based on role/ownership and content status (review mode vs edit mode).
    -   The Preview tab now mirrors the public content view layout (hero, gallery with modal, engagement, sidebar) for accurate review.
    -   Create/Edit cards use professional UI components for clearer grouping (Basic Info, Editor, Media, Publishing, Features, SEO, Stats).
    -   Website content page includes likes, comments, bookmarks (feature‑flagged), and dynamic gallery modal.
    -   Likes, comments, and bookmark are feature‑flagged per content. Heart reacts are per‑user toggles; counts update live.
    -   Comments support create, inline edit, and delete via AJAX with live counters.
    -   Tabs: My Content; Published; Archived (Manager/Admin). Program Coordinators see Submitted and Needs Revision; Managers/Admins see Needs Approval.

### 7. Financial Management (`/finance`)

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
 -   **Public Donations (Website `Donate`):**
    -   Guests or users can submit donations from the website.
    -   Upload receipt proof (optional); records stored as Pending until confirmed in Finance.
    -   When submitted from website, a thank‑you flow and toast are shown.

### 8. Participant Rules (Attendance, Tasks, and Feedback)

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

### 9. Notifications (`/notifications`)

-   Invitation notifications are pinned to the top and also listed in the general feed.
-   Mark‑as‑read redirects contextually (invitation page, payment reminder details, or `action_url`).
-   Bulk “Mark all as read” supported.
-   Payment reminder details link to the specific membership payment context.

### 10. UI/UX Feedback (Toasts and Alerts)

-   The system uses toasts and alerts to provide clear feedback for all major actions, such as:
    -   Creating, updating, or deleting programs and tasks.
    -   Joining or leaving a program.
    -   Approving, denying, or managing volunteers.
    -   Role assignments and permission changes.
    -   Financial transactions and payment processing.
    -   Member invitations and status updates.
    -   All successful actions and error conditions.

### 11. Team Members (`/content/team-members` and dynamic team pages)

-   Manage team member profiles, including name, position, bio, photo, links, category (founder, executive, member, developer), and active status. This information appears on the "Meet The Team" page of the website.

### 12. Consultation Hours (`/consultation-hours`)

-   Users can define consultation hours (day, time window, specialization) with active/inactive status for visibility.
-   Hours are shown in consultation contexts (e.g., program/participants side panels) sorted by day and start time.
-   Only owners can edit/delete their hours; validation ensures proper time ranges.
 -   Starting a chat from hours opens a 1‑to‑1 thread with that user (self links are disabled).

### 13. Consultation Chats (1‑to‑1) (`/consultation-chats`)

-   Any two users can start a private consultation thread. If a thread already exists, it will be reused; otherwise, a new one will be created.
-   Messages display sender, timestamps, and support deletion by the sender.
-   Authorization ensures only participants can view threads/messages.
-   Real‑time events broadcast new messages and deletions for live updates.

### 14. Program Chats (Group) (`/programs/chats`)

-   Each program has a persistent group chat created on program creation with a pinned welcome system message.
-   Participants are the coordinator and approved volunteers; access is enforced per program membership.
-   Messages stream chronologically with pagination; send/delete with real‑time broadcast updates.

### 15. Program Requests (Website `Program Request`)

-   Public users can submit program requests with name, title, description, audience, location, and proposed date.
-   Requests are listed for review in the dashboard; successful submission redirects to Programs with a toast.

### General

-   All Photos are stored in `storage/uploads/` with safe filenames; previous photos are cleaned up on update.
 -   Tabs across list pages (Programs, Content, Finance, Members, Volunteers) preserve the active tab across pagination via `?tab=` query params.
