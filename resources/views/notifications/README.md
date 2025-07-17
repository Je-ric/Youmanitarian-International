# Notification System Guide

## Overview
The notification system keeps users informed about important events and actions in the Youmanitarian International platform. Notifications are sent to users for things like payment reminders, program updates, task assignments, invitations, and more.

## Notification Types: Who Gets What and When?

| Type                          | What Triggers It?                                              | Who Receives It?                        |
|-------------------------------|---------------------------------------------------------------|-----------------------------------------|
| `payment_reminder`            | A payment reminder is created for a membership fee            | The member/user who owes the payment    |
| `task_assigned`               | A program coordinator assigns a task to a volunteer           | The volunteer assigned to the task      |
| `program_volunteer_attendance`| A coordinator approves/rejects a volunteer's attendance       | The volunteer whose attendance is updated|
| `program_update`              | A new program is created                                      | All users with the Volunteer role       |
| `member_invitation`           | A user is invited to become a member                          | The invited user                        |
| `volunteer_joined`            | A volunteer joins a program                                   | The program's coordinator               |
| `volunteer_application`       | A volunteer's application is approved or denied               | The volunteer who applied               |
| `role_update`                 | An admin updates a user's roles                               | The user whose roles changed            |

---

## Detailed Notification Explanations

### 1. Payment Reminder (`payment_reminder`)
- **What:** Notifies a user that they have a pending membership payment.
- **When/Why:** Sent when a payment reminder is created by a coordinator or system for a member's unpaid or upcoming membership fee.
- **Who:** The member/user who needs to pay.

### 2. Task Assigned (`task_assigned`)
- **What:** Informs a volunteer that they have been assigned a new task in a program.
- **When/Why:** Triggered when a program coordinator assigns a task to a volunteer in a program.
- **Who:** The volunteer who was assigned the task.

### 3. Program Volunteer Attendance (`program_volunteer_attendance`)
- **What:** Lets a volunteer know their attendance status (approved/rejected) for a program.
- **When/Why:** Sent when a program coordinator approves or rejects a volunteer's attendance record.
- **Who:** The volunteer whose attendance was updated.

### 4. Program Update (`program_update`)
- **What:** Announces that a new program is available for volunteers.
- **When/Why:** Sent when a new program is created in the system.
- **Who:** All users with the Volunteer role.

### 5. Member Invitation (`member_invitation`)
- **What:** Invites a user to become a member of the organization.
- **When/Why:** Sent when an admin or coordinator invites a user (usually a volunteer) to become a member.
- **Who:** The invited user.

### 6. Volunteer Joined (`volunteer_joined`)
- **What:** Notifies a program coordinator that a volunteer has joined their program.
- **When/Why:** Sent when a volunteer successfully joins a program.
- **Who:** The coordinator (creator) of the program.

### 7. Volunteer Application (`volunteer_application`)
- **What:** Updates a volunteer about the status of their application (approved or denied).
- **When/Why:** Sent when an admin or coordinator approves or denies a volunteer's application.
- **Who:** The volunteer who applied.

### 8. Role Update (`role_update`)
- **What:** Informs a user that their roles (permissions) have changed.
- **When/Why:** Sent when an admin updates a user's roles (adds or removes roles).
- **Who:** The user whose roles were changed.

---

## Notification Redirects and Special Pages

Some notifications have a dedicated view page (showing details and actions), while others redirect directly to a relevant resource. Here is a summary of what happens when each notification is clicked:

| Notification Type                | Dedicated View Page? | Redirects To (Route/Page)                                                                 |
|-----------------------------------|:-------------------:|------------------------------------------------------------------------------------------|
| `payment_reminder`                | Yes                 | `/notifications/{id}/payment-reminder` (see `notifications.show_payment_reminder` route)  |
| `member_invitation`               | Yes                 | `/members/invitation/{member}` (see `member.invitation.show` route)                       |
| `task_assigned`                   | No                  | `/programs/{program}/attendance` (see `programs.view` route)                              |
| `program_volunteer_attendance`    | No                  | `/programs/{program}/attendance` (see `programs.view` route)                              |
| `program_update`                  | No                  | `/programs/list?modal={program_id}` (see `programs.index` route, opens modal if supported)|
| `volunteer_joined`                | No                  | `/programs/{program}/volunteers/manage` (see `programs.manage_volunteers` route)          |
| `volunteer_application`           | No                  | `/programs/list` or `/dashboard` (see `programs.index` or `dashboard` route)              |
| `role_update`                     | No                  | `/dashboard`                                                                              |

**Explanation:**
- **Dedicated View Page:** The notification opens a special page showing all details and possible actions (e.g., payment reminder, invitation).
- **Direct Redirect:** The notification takes the user straight to the relevant resource (e.g., program attendance, dashboard, etc.).
- **Modal:** For new program notifications, the user is redirected to the program list page, and a modal for the new program can be opened if the view supports it.

---

## How Notifications Work
- **Trigger:** Notifications are sent from the backend (usually in controllers or service classes) when certain events occur (see above).
- **Delivery:** Most notifications use Laravel's `database` channel, so they are stored in the `notifications` table and shown in the web UI.
- **Display:** Users see their notifications in the Notifications page (`/notifications/list`). Unread notifications are highlighted.
- **Interaction:** Clicking a notification marks it as read and redirects the user to a relevant page (e.g., payment details, attendance, program info, etc.).

## How Notifications Are Sent
Notifications are sent using Laravel's notification system. Example:

```
// Send a payment reminder
$user->notify(new \App\Notifications\PaymentReminder($reminder));

// Assign a task to a volunteer
$volunteer->user->notify(new \App\Notifications\TaskAssigned($task, $program));

// Notify all volunteers of a new program
foreach ($volunteers as $volunteer) {
    $volunteer->user->notify(new \App\Notifications\NewProgramAvailable($program));
}
```

## Adding a New Notification Type
1. Create a new notification class in `app/Notifications/`.
2. Implement the `toArray()` method to include at least:
    - `type` (string)
    - `title` (string)
    - `message` (string)
    - `action_url` (optional, for custom redirects)
    - Any IDs needed for routing (e.g., `program_id`)
3. Update the notification rendering logic in `index.blade.php` if special routing is needed.
4. Send the notification from your controller or service.

## Example: Creating a Custom Notification
```
php artisan make:notification CustomAlert
```
Edit the generated file:
```
public function toArray($notifiable)
{
    return [
        'type' => 'custom_alert',
        'title' => 'Custom Alert',
        'message' => 'This is a custom notification.',
        'action_url' => route('dashboard'),
    ];
}
```

## References
- [Laravel Notifications Documentation](https://laravel.com/docs/notifications)
- `app/Notifications/` for notification classes
- `app/Http/Controllers/NotificationController.php` for controller logic
- `resources/views/notifications/index.blade.php` for the notification list UI 