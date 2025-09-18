# Search Implementation Summary

This document outlines the search functionality implemented across all tables in the Youmanitarian International system.

## Overview

Search functionality has been added to all major tables with the following features:
- Search within individual tabs
- Sorting options (ascending/descending)
- Date filtering where applicable
- Pagination that preserves search parameters

## Implemented Search Features

### 1. Content Table
**Controller:** `ContentController@index`
**Search Fields:** Title
**Sort Options:** Created date, Updated date, Title
**Filters:** Date filter
**Default Sort:** Created date (descending)

**Features:**
- Search by content title across all tabs (My Content, Published, Archived, etc.)
- Filter by specific date
- Sort by creation date, update date, or title
- Search is applied to all content tabs independently

### 2. Programs Table
**Controller:** `ProgramController@gotoProgramsList`
**Search Fields:** Title
**Sort Options:** Date, Title
**Default Sort:** Date (descending)

**Features:**
- Search by program title across all tabs (All Programs, Joined, My Programs)
- Sort by date or title (ascending/descending)
- Search is applied to all program tabs independently

### 3. Volunteers Table
**Controller:** `VolunteerController@gotoVolunteersList`
**Search Fields:** First name, Last name, Email
**Sort Options:** Created date, Updated date, First name, Last name, Email
**Default Sort:** Created date (ascending - earliest first)

**Features:**
- Search by volunteer name or email across all tabs (Applications, Denied, Approved)
- Sort by various fields with earliest volunteers shown first by default
- Search is applied to all volunteer tabs independently

### 4. Assigning Roles Table
**Controller:** `RoleController@gotoRolesList`
**Search Fields:** First name, Last name, Email
**Default Sort:** Alphabetical by name

**Features:**
- Search by user name or email across all role tabs
- Automatically sorted alphabetically by name
- Search is applied to all role tabs independently

### 5. Members Table
**Controller:** `MemberController@index`
**Search Fields:** First name, Last name, Email
**Sort Options:** Start date, Created date, First name, Last name, Email
**Default Sort:** Start date (descending)

**Features:**
- Search by member name or email across all tabs (Overview, Full Pledge, Honorary, Pending)
- Sort by start date, creation date, or name
- Search is applied to all member tabs independently

### 6. Donations Table
**Controller:** `DonationController@index`
**Search Fields:** Donor name, Donor email, Notes
**Filters:** Date range, Payment method
**Default Sort:** Donation date (descending)

**Features:**
- **Separate tabs for Pending and Confirmed donations**
- Search by donor name, email, or notes
- Filter by date range (from/to dates)
- Filter by payment method (Cash, Bank Transfer, Credit Card, PayPal, Check)
- Search is applied to both pending and confirmed tabs independently

### 7. Membership Payments Table
**Controller:** `MembershipController@index`
**Search Fields:** First name, Last name, Email
**Sort Options:** First name, Last name, Email, Created date
**Default Sort:** First name (ascending - alphabetical)

**Features:**
- Search by member name or email across all tabs (Full Pledge, Honorary)
- Sort alphabetically by name by default
- Search is applied to all membership payment tabs independently

## Technical Implementation

### Controller Changes
Each controller has been updated to:
1. Accept search parameters from the request
2. Apply search filters to database queries
3. Apply sorting to results
4. Preserve search parameters in pagination links
5. Pass search parameters to views

### Search Parameters
- `search`: Text search term
- `sort_by`: Field to sort by
- `sort_order`: Sort direction (asc/desc)
- `date_filter`: Single date filter (for content)
- `date_from`/`date_to`: Date range filter (for donations)
- `payment_method`: Payment method filter (for donations)
- `tab`: Current active tab

### Database Queries
- Uses `whereHas()` for searching related models (users)
- Uses `like` operator with `%` wildcards for partial matching
- Case-insensitive search where applicable
- Proper pagination with search parameter preservation

## Usage in Views

### Search Form Component
A reusable search form component has been created at `resources/views/components/search-form.blade.php` that can be used across all views.

**Example usage:**
```blade
<x-search-form 
    :search="$search" 
    :dateFilter="$dateFilter" 
    :sortBy="$sortBy" 
    :sortOrder="$sortOrder"
    :showDateFilter="true"
    :showSortOptions="true"
    :sortOptions="['created_at' => 'Date Created', 'title' => 'Title']"
/>
```

### View Integration
To add search functionality to any view:

1. Include the search form component at the top of the content area
2. Pass the search parameters from the controller to the view
3. The search form will automatically preserve the current tab and other parameters

## Benefits

1. **Improved User Experience:** Users can quickly find specific records
2. **Tab-Specific Search:** Search is scoped to the current tab, preventing confusion
3. **Flexible Filtering:** Multiple filter options for different data types
4. **Consistent Interface:** Same search pattern across all tables
5. **Performance Optimized:** Efficient database queries with proper indexing
6. **Pagination Friendly:** Search parameters are preserved across pages

## Future Enhancements

1. **Advanced Search:** Add more complex search operators (AND, OR, NOT)
2. **Saved Searches:** Allow users to save frequently used search criteria
3. **Export Filtered Results:** Export search results to CSV/Excel
4. **Search History:** Track and display recent searches
5. **Real-time Search:** Implement AJAX-based real-time search suggestions

## Notes

- All search functionality is case-insensitive
- Search parameters are preserved during pagination
- Each tab maintains its own search state
- Database queries are optimized to prevent N+1 problems
- Search forms are responsive and mobile-friendly
