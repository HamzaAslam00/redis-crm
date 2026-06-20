<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;

class EmailTemplatesSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'slug' => 'contact-auto-reply',
                'name' => 'Contact Form — Auto Reply to Sender',
                'subject' => 'We received your message, {client_name}!',
                'body' => $this->contactAutoReply(),
                'variables' => [
                    ['key' => 'client_name',   'desc' => "Sender's name"],
                    ['key' => 'client_email',  'desc' => "Sender's email"],
                    ['key' => 'message',       'desc' => 'Original message text'],
                    ['key' => 'company_name',  'desc' => 'Company name from settings'],
                    ['key' => 'company_phone', 'desc' => 'Company phone from settings'],
                ],
            ],
            [
                'slug' => 'contact-admin-notify',
                'name' => 'Contact Form — Admin Notification',
                'subject' => 'New Contact Inquiry from {client_name}',
                'body' => $this->contactAdminNotify(),
                'variables' => [
                    ['key' => 'client_name',      'desc' => "Sender's name"],
                    ['key' => 'client_email',     'desc' => "Sender's email"],
                    ['key' => 'client_phone',     'desc' => "Sender's phone"],
                    ['key' => 'service_interest', 'desc' => 'Selected service'],
                    ['key' => 'budget',           'desc' => 'Budget range'],
                    ['key' => 'message',          'desc' => 'Message content'],
                    ['key' => 'submitted_at',     'desc' => 'Submission timestamp'],
                ],
            ],
            [
                'slug' => 'contact-reply',
                'name' => 'Contact Message — Manual Reply',
                'subject' => 'Re: Your Inquiry — {company_name}',
                'body' => $this->contactReply(),
                'variables' => [
                    ['key' => 'client_name',      'desc' => "Client's name"],
                    ['key' => 'original_message', 'desc' => 'Original message they sent'],
                    ['key' => 'reply_body',       'desc' => 'Your reply content'],
                    ['key' => 'admin_name',       'desc' => 'Name of admin replying'],
                    ['key' => 'company_name',     'desc' => 'Company name from settings'],
                ],
            ],
            [
                'slug' => 'hosting-renewal-30d',
                'name' => 'Hosting Renewal — 30 Days Warning',
                'subject' => 'Hosting Renewal Reminder — {domain} expires in {days_left} days',
                'body' => $this->hostingRenewal('30-Day'),
                'variables' => [
                    ['key' => 'client_name',   'desc' => 'Client name'],
                    ['key' => 'domain',        'desc' => 'Domain name'],
                    ['key' => 'renewal_date',  'desc' => 'Renewal date'],
                    ['key' => 'days_left',     'desc' => 'Days remaining'],
                    ['key' => 'amount',        'desc' => 'Renewal amount'],
                    ['key' => 'company_email', 'desc' => 'Company email'],
                ],
            ],
            [
                'slug' => 'hosting-renewal-7d',
                'name' => 'Hosting Renewal — 7 Days Warning',
                'subject' => 'URGENT: {domain} hosting expires in {days_left} days!',
                'body' => $this->hostingRenewalUrgent(),
                'variables' => [
                    ['key' => 'client_name',   'desc' => 'Client name'],
                    ['key' => 'domain',        'desc' => 'Domain name'],
                    ['key' => 'renewal_date',  'desc' => 'Renewal date'],
                    ['key' => 'days_left',     'desc' => 'Days remaining'],
                    ['key' => 'amount',        'desc' => 'Renewal amount'],
                    ['key' => 'company_email', 'desc' => 'Company email'],
                ],
            ],
            [
                'slug' => 'project-deadline-7d',
                'name' => 'Project Deadline — 7 Days',
                'subject' => 'Project "{project_title}" deadline in {days_left} days',
                'body' => $this->projectDeadline(),
                'variables' => [
                    ['key' => 'project_title',  'desc' => 'Project name'],
                    ['key' => 'client_name',    'desc' => 'Client name'],
                    ['key' => 'deadline',       'desc' => 'Deadline date'],
                    ['key' => 'developer_name', 'desc' => 'Assigned developer'],
                    ['key' => 'project_url',    'desc' => 'CRM project URL'],
                ],
            ],
            [
                'slug' => 'welcome-user',
                'name' => 'New User Welcome',
                'subject' => 'Welcome to {company_name} CRM — Your Account Details',
                'body' => $this->welcomeUser(),
                'variables' => [
                    ['key' => 'user_name',     'desc' => "New user's name"],
                    ['key' => 'user_email',    'desc' => "New user's email"],
                    ['key' => 'temp_password', 'desc' => 'Temporary password'],
                    ['key' => 'login_url',     'desc' => 'CRM login URL'],
                    ['key' => 'company_name',  'desc' => 'Company name'],
                ],
            ],
            [
                'slug' => 'password-reset',
                'name' => 'Password Reset',
                'subject' => 'Reset Your Password',
                'body' => $this->passwordReset(),
                'variables' => [
                    ['key' => 'user_name',  'desc' => "User's name"],
                    ['key' => 'reset_link', 'desc' => 'Password reset link'],
                    ['key' => 'expires_in', 'desc' => 'Link expiry time'],
                ],
            ],
            [
                'slug' => 'proposal-sent',
                'name' => 'Proposal Sent to Client',
                'subject' => 'Your Proposal #{proposal_number} from {company_name}',
                'body' => $this->proposalSent(),
                'variables' => [
                    ['key' => 'client_name',     'desc' => "Client's name"],
                    ['key' => 'proposal_number', 'desc' => 'Proposal reference number'],
                    ['key' => 'project_title',   'desc' => 'Project title'],
                    ['key' => 'valid_until',     'desc' => 'Proposal validity date'],
                    ['key' => 'view_link',       'desc' => 'Link to view proposal PDF'],
                    ['key' => 'company_name',    'desc' => 'Company name'],
                ],
            ],
        ];

        foreach ($templates as $data) {
            $data['default_subject'] = $data['subject'];
            $data['default_body'] = $data['body'];
            $data['is_system'] = true;

            EmailTemplate::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }

    private function contactAutoReply(): string
    {
        return '<div style="font-family:Arial,sans-serif;max-width:600px;margin:0 auto;background:#ffffff"><div style="background:linear-gradient(135deg,#FF6400,#e05500);padding:32px 40px;border-radius:12px 12px 0 0"><h1 style="color:#fff;font-size:22px;margin:0;font-weight:700">Thank You for Reaching Out!</h1><p style="color:rgba(255,255,255,0.85);font-size:14px;margin:8px 0 0">Redis Solution Pvt. Ltd.</p></div><div style="padding:32px 40px;background:#f9f9f9"><p style="color:#333;font-size:16px;margin:0 0 20px">Hi <strong>{client_name}</strong>,</p><p style="color:#555;font-size:15px;line-height:1.7;margin:0 0 20px">Thank you for contacting <strong>{company_name}</strong>! We\'ve received your message and our team will get back to you within <strong>24 hours</strong>.</p><div style="background:#fff;border-left:4px solid #FF6400;padding:16px 20px;border-radius:0 8px 8px 0;margin:20px 0"><p style="color:#888;font-size:12px;text-transform:uppercase;letter-spacing:0.05em;margin:0 0 8px">Your Message</p><p style="color:#444;font-size:14px;line-height:1.6;margin:0">{message}</p></div><p style="color:#555;font-size:15px;line-height:1.7;margin:20px 0">In the meantime, you can also reach us at:<br>&#128222; <a href="tel:{company_phone}" style="color:#FF6400">{company_phone}</a></p><p style="color:#555;font-size:15px;margin:0">Best regards,<br><strong style="color:#FF6400">{company_name} Team</strong></p></div><div style="padding:16px 40px;background:#f0f0f0;border-radius:0 0 12px 12px;text-align:center"><p style="color:#aaa;font-size:12px;margin:0">&copy; {company_name} &mdash; All rights reserved.</p></div></div>';
    }

    private function contactAdminNotify(): string
    {
        return '<div style="font-family:Arial,sans-serif;max-width:600px;margin:0 auto;background:#ffffff"><div style="background:#1A1829;padding:24px 32px;border-radius:12px 12px 0 0;border-bottom:3px solid #FF6400"><h1 style="color:#FF6400;font-size:18px;margin:0;font-weight:700">&#128276; New Contact Inquiry</h1><p style="color:rgba(255,255,255,0.5);font-size:13px;margin:6px 0 0">Submitted: {submitted_at}</p></div><div style="padding:24px 32px;background:#f9f9f9"><table style="width:100%;border-collapse:collapse"><tr><td style="padding:10px 0;border-bottom:1px solid #eee;color:#888;font-size:13px;width:140px">Name</td><td style="padding:10px 0;border-bottom:1px solid #eee;color:#333;font-weight:600">{client_name}</td></tr><tr><td style="padding:10px 0;border-bottom:1px solid #eee;color:#888;font-size:13px">Email</td><td style="padding:10px 0;border-bottom:1px solid #eee"><a href="mailto:{client_email}" style="color:#FF6400">{client_email}</a></td></tr><tr><td style="padding:10px 0;border-bottom:1px solid #eee;color:#888;font-size:13px">Phone</td><td style="padding:10px 0;border-bottom:1px solid #eee;color:#333">{client_phone}</td></tr><tr><td style="padding:10px 0;border-bottom:1px solid #eee;color:#888;font-size:13px">Service</td><td style="padding:10px 0;border-bottom:1px solid #eee;color:#333">{service_interest}</td></tr><tr><td style="padding:10px 0;border-bottom:1px solid #eee;color:#888;font-size:13px">Budget</td><td style="padding:10px 0;border-bottom:1px solid #eee;color:#333">{budget}</td></tr></table><div style="margin-top:20px"><p style="color:#888;font-size:12px;text-transform:uppercase;letter-spacing:0.05em;margin:0 0 10px">Message</p><div style="background:#fff;border:1px solid #eee;border-radius:8px;padding:16px;color:#333;font-size:14px;line-height:1.7">{message}</div></div></div></div>';
    }

    private function contactReply(): string
    {
        return '<div style="font-family:Arial,sans-serif;max-width:600px;margin:0 auto;background:#ffffff"><div style="background:linear-gradient(135deg,#FF6400,#e05500);padding:28px 36px;border-radius:12px 12px 0 0"><h1 style="color:#fff;font-size:20px;margin:0;font-weight:700">Reply from {company_name}</h1></div><div style="padding:28px 36px;background:#f9f9f9"><p style="color:#333;font-size:15px;margin:0 0 16px">Hi <strong>{client_name}</strong>,</p><div style="background:#fff;border-radius:10px;padding:20px 24px;margin-bottom:20px;font-size:15px;color:#333;line-height:1.75;white-space:pre-wrap">{reply_body}</div><div style="background:#f0f0f0;border-left:3px solid #ccc;padding:12px 16px;border-radius:0 6px 6px 0;margin-top:20px"><p style="color:#aaa;font-size:11px;text-transform:uppercase;letter-spacing:0.05em;margin:0 0 6px">Your Original Message</p><p style="color:#777;font-size:13px;line-height:1.6;margin:0">{original_message}</p></div><p style="color:#555;font-size:14px;margin:24px 0 0">Best regards,<br><strong style="color:#FF6400">{admin_name}</strong><br>{company_name}</p></div></div>';
    }

    private function hostingRenewal(string $type = '30-Day'): string
    {
        return '<div style="font-family:Arial,sans-serif;max-width:600px;margin:0 auto;background:#ffffff"><div style="background:#1e40af;padding:28px 36px;border-radius:12px 12px 0 0"><h1 style="color:#fff;font-size:20px;margin:0;font-weight:700">&#9200; Hosting Renewal Reminder</h1><p style="color:rgba(255,255,255,0.8);font-size:14px;margin:8px 0 0">Renew before your hosting expires</p></div><div style="padding:28px 36px;background:#f9f9f9"><p style="color:#333;font-size:15px;margin:0 0 20px">Dear <strong>{client_name}</strong>,</p><p style="color:#555;font-size:15px;line-height:1.7;margin:0 0 20px">This is a friendly reminder that hosting for <strong style="color:#1e40af">{domain}</strong> is due for renewal in <strong>{days_left} days</strong>.</p><div style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:8px;padding:20px;margin:20px 0"><table style="width:100%;border-collapse:collapse"><tr><td style="padding:8px 0;color:#555;font-size:14px">Domain</td><td style="color:#1e40af;font-weight:700;font-size:14px">{domain}</td></tr><tr><td style="padding:8px 0;color:#555;font-size:14px">Renewal Date</td><td style="color:#333;font-weight:600;font-size:14px">{renewal_date}</td></tr><tr><td style="padding:8px 0;color:#555;font-size:14px">Amount Due</td><td style="color:#333;font-weight:600;font-size:14px">{amount}</td></tr></table></div><p style="color:#555;font-size:14px">Contact us: <a href="mailto:{company_email}" style="color:#FF6400">{company_email}</a></p></div></div>';
    }

    private function hostingRenewalUrgent(): string
    {
        return '<div style="font-family:Arial,sans-serif;max-width:600px;margin:0 auto;background:#ffffff"><div style="background:#dc2626;padding:28px 36px;border-radius:12px 12px 0 0"><h1 style="color:#fff;font-size:20px;margin:0;font-weight:700">&#128680; URGENT: Hosting Expiring in {days_left} Days!</h1></div><div style="padding:28px 36px;background:#fff9f9"><p style="color:#333;font-size:15px;margin:0 0 16px">Dear <strong>{client_name}</strong>,</p><p style="color:#555;font-size:15px;line-height:1.7;margin:0 0 20px"><strong style="color:#dc2626">Action required immediately.</strong> Your hosting for <strong>{domain}</strong> expires on <strong>{renewal_date}</strong> &mdash; that\'s only <strong>{days_left} days away</strong>.</p><div style="background:#fef2f2;border:2px solid #fca5a5;border-radius:8px;padding:20px;margin:20px 0;text-align:center"><p style="color:#dc2626;font-size:24px;font-weight:800;margin:0">{days_left} Days Left</p><p style="color:#555;font-size:14px;margin:8px 0 0">Domain: {domain} | Renewal: {renewal_date}</p></div><p style="color:#555;font-size:14px">Contact us now: <a href="mailto:{company_email}" style="color:#FF6400">{company_email}</a></p></div></div>';
    }

    private function projectDeadline(): string
    {
        return '<div style="font-family:Arial,sans-serif;max-width:600px;margin:0 auto;background:#ffffff"><div style="background:#7c3aed;padding:28px 36px;border-radius:12px 12px 0 0"><h1 style="color:#fff;font-size:20px;margin:0;font-weight:700">&#128197; Project Deadline Approaching</h1></div><div style="padding:28px 36px;background:#f9f9f9"><p style="color:#333;font-size:15px;margin:0 0 20px">Hi <strong>{developer_name}</strong>,</p><p style="color:#555;font-size:15px;line-height:1.7;margin:0 0 20px">The project <strong style="color:#7c3aed">&quot;{project_title}&quot;</strong> for <strong>{client_name}</strong> has a deadline in <strong>7 days</strong> on <strong>{deadline}</strong>.</p><p style="margin:24px 0"><a href="{project_url}" style="display:inline-block;background:#7c3aed;color:#fff;padding:12px 24px;border-radius:8px;text-decoration:none;font-weight:700;font-size:14px">View Project &#8594;</a></p></div></div>';
    }

    private function welcomeUser(): string
    {
        return '<div style="font-family:Arial,sans-serif;max-width:600px;margin:0 auto;background:#ffffff"><div style="background:linear-gradient(135deg,#FF6400,#e05500);padding:32px 40px;border-radius:12px 12px 0 0"><h1 style="color:#fff;font-size:22px;margin:0;font-weight:700">Welcome to {company_name}!</h1><p style="color:rgba(255,255,255,0.85);font-size:14px;margin:8px 0 0">Your CRM account is ready</p></div><div style="padding:32px 40px;background:#f9f9f9"><p style="color:#333;font-size:15px;margin:0 0 20px">Hi <strong>{user_name}</strong>,</p><p style="color:#555;font-size:15px;line-height:1.7;margin:0 0 24px">Your account has been created. Here are your login details:</p><div style="background:#fff;border:1px solid #e5e5e5;border-radius:8px;padding:20px"><table style="width:100%;border-collapse:collapse"><tr><td style="padding:8px 0;color:#888;font-size:13px;width:100px">Email</td><td style="color:#333;font-weight:600">{user_email}</td></tr><tr><td style="padding:8px 0;color:#888;font-size:13px">Password</td><td style="color:#FF6400;font-weight:700;font-size:16px">{temp_password}</td></tr></table></div><p style="color:#ef4444;font-size:13px;margin:16px 0">&#9888;&#65039; Please change your password immediately after first login.</p><p style="margin:24px 0"><a href="{login_url}" style="display:inline-block;background:#FF6400;color:#fff;padding:12px 28px;border-radius:8px;text-decoration:none;font-weight:700;font-size:15px">Login to CRM &#8594;</a></p></div></div>';
    }

    private function passwordReset(): string
    {
        return '<div style="font-family:Arial,sans-serif;max-width:600px;margin:0 auto;background:#ffffff"><div style="background:#1A1829;padding:28px 36px;border-radius:12px 12px 0 0;border-bottom:3px solid #FF6400"><h1 style="color:#fff;font-size:20px;margin:0;font-weight:700">&#128272; Password Reset Request</h1></div><div style="padding:28px 36px;background:#f9f9f9"><p style="color:#333;font-size:15px;margin:0 0 16px">Hi <strong>{user_name}</strong>,</p><p style="color:#555;font-size:15px;line-height:1.7;margin:0 0 24px">We received a request to reset your password. Click the button below to set a new password. This link expires in <strong>{expires_in}</strong>.</p><p style="margin:24px 0;text-align:center"><a href="{reset_link}" style="display:inline-block;background:#FF6400;color:#fff;padding:14px 32px;border-radius:8px;text-decoration:none;font-weight:700;font-size:15px">Reset Password &#8594;</a></p><p style="color:#aaa;font-size:13px;border-top:1px solid #eee;padding-top:16px;margin:24px 0 0">If you didn\'t request a password reset, please ignore this email.</p></div></div>';
    }

    private function proposalSent(): string
    {
        return '<div style="font-family:Arial,sans-serif;max-width:600px;margin:0 auto;background:#ffffff"><div style="background:linear-gradient(135deg,#FF6400,#e05500);padding:32px 40px;border-radius:12px 12px 0 0"><h1 style="color:#fff;font-size:22px;margin:0;font-weight:700">Your Proposal is Ready! &#127881;</h1><p style="color:rgba(255,255,255,0.85);font-size:14px;margin:8px 0 0">{company_name}</p></div><div style="padding:32px 40px;background:#f9f9f9"><p style="color:#333;font-size:15px;margin:0 0 20px">Hi <strong>{client_name}</strong>,</p><p style="color:#555;font-size:15px;line-height:1.7;margin:0 0 20px">We\'re excited to share our proposal for <strong>&quot;{project_title}&quot;</strong>. Please review it at your convenience.</p><div style="background:#fff;border:1px solid #e5e5e5;border-radius:8px;padding:20px;margin:20px 0"><table style="width:100%;border-collapse:collapse"><tr><td style="padding:8px 0;color:#888;font-size:13px;width:140px">Proposal #</td><td style="color:#FF6400;font-weight:700">{proposal_number}</td></tr><tr><td style="padding:8px 0;color:#888;font-size:13px">Project</td><td style="color:#333;font-weight:600">{project_title}</td></tr><tr><td style="padding:8px 0;color:#888;font-size:13px">Valid Until</td><td style="color:#333;font-weight:600">{valid_until}</td></tr></table></div><p style="margin:24px 0"><a href="{view_link}" style="display:inline-block;background:#FF6400;color:#fff;padding:14px 28px;border-radius:8px;text-decoration:none;font-weight:700;font-size:15px">View Proposal PDF &#8594;</a></p><p style="color:#555;font-size:14px;margin:0">Best regards,<br><strong style="color:#FF6400">{company_name} Team</strong></p></div></div>';
    }
}
