<!DOCTYPE html>
<html>
<head>
    <title>Membership Invitation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .content {
            margin-bottom: 30px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #45a049;
        }
        .button.decline {
            background-color: #f44336;
        }
        .button.decline:hover {
            background-color: #da190b;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #666;
            margin-top: 30px;
            padding: 20px;
            border-top: 1px solid #eee;
        }
        ul {
            list-style-type: none;
            padding-left: 0;
        }
        li {
            margin-bottom: 10px;
            padding-left: 20px;
            position: relative;
        }
        li:before {
            content: "•";
            color: #4CAF50;
            position: absolute;
            left: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to YouManitarian International!</h1>
        </div>
        
        <div class="content">
            <p>Dear <?php echo e($member->user->name ?? 'Valued Member'); ?>,</p>
            
            <p>We are pleased to invite you to become a member of YouManitarian International. Your dedication and contributions to our cause have been remarkable, and we believe you would be a valuable addition to our community.</p>
            
            <p>As a member, you will have access to:</p>
            <ul>
                <li>Exclusive events and programs</li>
                <li>Networking opportunities with other members</li>
                <li>Priority access to volunteer opportunities</li>
                <li>And much more!</li>
            </ul>
            
            <p>Please click one of the buttons below to respond to this invitation:</p>
            
            <div style="text-align: center;">
                <a href="<?php echo e($acceptUrl); ?>" class="button">Accept Invitation</a>
                <a href="<?php echo e($declineUrl); ?>" class="button decline">Decline Invitation</a>
            </div>

            <p style="margin-top: 20px; font-size: 14px; color: #666;">
                If the buttons above don't work, you can copy and paste these links into your browser:<br>
                Accept: <?php echo e($acceptUrl); ?><br>
                Decline: <?php echo e($declineUrl); ?>

            </p>
        </div>
        
        <div class="footer">
            <p>This invitation will expire in 7 days.</p>
            <p>If you have any questions, please contact our support team.</p>
        </div>
    </div>
</body>
</html> <?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/emails/member-invitation.blade.php ENDPATH**/ ?>