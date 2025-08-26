# Donation Download Functionality

This document describes the new download functionality added to the donations management system.

## Features

### 1. Individual Donation Downloads
- **Format**: PDF (with CSV fallback)
- **Content**: Complete donation receipt with all details
- **Access**: Available from both the donations table and view modal
- **Route**: `GET /finance/donations/{donation}/download`

### 2. Bulk Donation Downloads
- **Formats**: CSV and PDF
- **Content**: All donations with comprehensive data
- **Access**: "Download All" button in the page header
- **Route**: `GET /finance/donations/download/all?format=csv|pdf`

## Implementation Details

### Controller Methods
- `downloadSpecificDonation(Donation $donation)` - Downloads individual donation as PDF
- `downloadAllDonations(Request $request)` - Downloads all donations in specified format
- `downloadSpecificDonationAsCSV(Donation $donation)` - Fallback CSV for individual donations
- `downloadAllDonationsAsCSV()` - Downloads all donations as CSV
- `downloadAllDonationsAsPDF()` - Downloads all donations as PDF
- `getFilteredDonations()` - Gets filtered donations based on request parameters

### Routes
```php
// Individual donation download
Route::get('/finance/donations/{donation}/download', [DonationController::class, 'downloadSpecificDonation'])
    ->name('finance.donations.download');

// Bulk download
Route::get('/finance/donations/download/all', [DonationController::class, 'downloadAllDonations'])
    ->name('finance.donations.download.all');
```

### PDF Templates
- `resources/views/finance/pdfs/donation.blade.php` - Individual donation receipt
- `resources/views/finance/pdfs/all_donations.blade.php` - Comprehensive donations report

### Error Handling
- Automatic fallback to CSV if PDF generation fails
- Graceful error handling for missing dependencies
- User-friendly error messages

## Usage

### For Users
1. **Download Individual Donation**:
   - Click the "PDF" button in the Actions column
   - Or click "Download Receipt" in the view modal

2. **Download All Donations**:
   - Click "Download All" button in the page header
   - Choose between CSV or PDF format
   - CSV is recommended for data analysis
   - PDF is recommended for printing and archiving

### For Developers
1. **Adding New Download Formats**:
   - Extend the `downloadAllDonations` method
   - Add new format handling logic
   - Create corresponding view templates

2. **Customizing PDF Templates**:
   - Modify the Blade templates in `resources/views/finance/pdfs/`
   - Update CSS styles for PDF generation
   - Add new fields or sections as needed

3. **Adding Filters**:
   - Extend the `getFilteredDonations` method
   - Add new filter parameters
   - Update the download methods to use filters

## Dependencies

### Required Packages
- `barryvdh/laravel-dompdf` - For PDF generation
- Laravel 12.x - Framework requirements

### Installation
```bash
composer require barryvdh/laravel-dompdf
php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"
```

## Security

### Access Control
- All download methods require authentication
- Role-based access control (Financial Coordinator role required)
- Middleware protection on all routes

### Data Protection
- Sensitive information is handled securely
- Anonymous donations are properly masked
- User permissions are verified before download

## Performance Considerations

### Large Datasets
- CSV downloads are streamed for memory efficiency
- PDF generation includes error handling for large datasets
- Consider pagination for very large donation lists

### Caching
- PDF templates can be cached for better performance
- Consider implementing download caching for frequently accessed reports

## Troubleshooting

### Common Issues
1. **PDF Generation Fails**:
   - Check if DomPDF is properly installed
   - Verify PDF template syntax
   - Check server memory limits

2. **CSV Download Issues**:
   - Verify file permissions
   - Check output buffering settings
   - Ensure proper headers are set

3. **Permission Errors**:
   - Verify user authentication
   - Check role assignments
   - Review middleware configuration

### Debug Mode
- Enable Laravel debug mode for detailed error messages
- Check Laravel logs for specific error details
- Verify route registration with `php artisan route:list`

## Future Enhancements

### Planned Features
- Email delivery of reports
- Scheduled report generation
- Advanced filtering options
- Custom report templates
- Export to additional formats (Excel, JSON)

### Integration Opportunities
- Connect with accounting software
- Integration with donor management systems
- Automated report scheduling
- Advanced analytics and reporting
