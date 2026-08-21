<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Guide;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GuideSeeder extends Seeder
{
    public function run(): void
    {
        $guides = [
            // ---------- Wifi ----------
            [
                'category' => 'wifi',
                'tag' => 'WIFI-04',
                'title' => 'Connecting to CPUT wifi',
                'summary' => 'Takes about 2 minutes. Works on phones, laptops and tablets.',
                'steps' => [
                    'Open Wifi settings on your device and select CPUT-Students.',
                    'Enter your student number as the username, no @cput.ac.za needed.',
                    'Enter your myCPUT password, then tap connect.',
                    "If it doesn't connect, forget the network and repeat step 1.",
                ],
            ],
            [
                'category' => 'wifi',
                'tag' => 'WIFI-07',
                'title' => 'Connecting to eduroam off campus',
                'summary' => 'For partner institutions that also support eduroam.',
                'steps' => [
                    'Select eduroam from the available networks list.',
                    'Username is studentnumber@cput.ac.za.',
                    'Password is your myCPUT password.',
                ],
            ],
            [
                'category' => 'wifi',
                'tag' => 'WIFI-09',
                'title' => 'Wifi is connected but you have no internet access',
                'summary' => "Fixes the 'connected, no internet' message on CPUT-Students.",
                'steps' => [
                    'Forget the CPUT-Students network on your device.',
                    'Turn wifi off and back on, then reconnect and re-enter your details.',
                    'If your device shows a captive portal or login page, open a browser and complete it before using other apps.',
                    'Still nothing after 5 minutes? Restart your device and try once more before contacting the Service Desk.',
                ],
            ],

            // ---------- Registration ----------
            [
                'category' => 'registration',
                'tag' => 'REG-01',
                'title' => 'Getting your proof of registration',
                'summary' => 'Download an official copy in under a minute.',
                'steps' => [
                    'Log into the myCPUT student portal.',
                    "Go to 'Student Administration' then 'Registration'.",
                    "Click 'Print Proof of Registration' and save the PDF.",
                ],
            ],
            [
                'category' => 'registration',
                'tag' => 'REG-05',
                'title' => 'Registering online for the new academic year',
                'summary' => 'Complete your annual re-registration from home.',
                'steps' => [
                    'Log into the myCPUT student portal with your student number and password.',
                    "Go to 'Student Administration' then 'Registration'.",
                    'Check that your personal and banking details are correct before continuing.',
                    "Confirm your module selections for the year and click 'Submit Registration'.",
                    'Download your registration confirmation once payment or NSFAS clearance reflects.',
                ],
            ],
            [
                'category' => 'registration',
                'tag' => 'REG-08',
                'title' => 'Applying for a deferred or aegrotat exam',
                'summary' => 'For students who missed an exam due to illness or another valid reason.',
                'steps' => [
                    'Log into the myCPUT student portal within 3 working days of the missed exam.',
                    "Go to 'Assessments' then 'Deferred Exam Application'.",
                    'Upload supporting documents, such as a medical certificate.',
                    'Submit the application and note your reference number.',
                    'Check your student email for the outcome from the faculty.',
                ],
            ],

            // ---------- Email ----------
            [
                'category' => 'email',
                'tag' => 'EML-02',
                'title' => 'Setting up your student email on your phone',
                'summary' => 'Add your CPUT email to the Outlook or Mail app.',
                'steps' => [
                    'Open your mail app and choose Add Account.',
                    'Enter your full CPUT student email address.',
                    'Enter your myCPUT password when prompted.',
                    'Allow the app a minute to sync your inbox.',
                ],
            ],
            [
                'category' => 'email',
                'tag' => 'EML-06',
                'title' => 'Recovering a locked student email account',
                'summary' => 'Your email password is separate from some other CPUT logins, so this can trip people up.',
                'steps' => [
                    'Go to password.cput.ac.za and choose the reset option.',
                    'Enter your student number and registered cellphone number.',
                    'Enter the OTP sent to your phone.',
                    'Set a new password, then use it to log into your student email again.',
                    'If your phone number is out of date, this guide will not work -- contact the Service Desk to update it first.',
                ],
            ],

            // ---------- Printing ----------
            [
                'category' => 'printing',
                'tag' => 'PRT-03',
                'title' => 'Loading printing credits',
                'summary' => 'Top up your printing balance from any campus kiosk.',
                'steps' => [
                    'Locate a top-up kiosk in the library or IT lab.',
                    'Tap your student card on the reader.',
                    'Insert cash or card and select the amount to load.',
                    'Wait for the confirmation slip before removing your card.',
                ],
            ],
            [
                'category' => 'printing',
                'tag' => 'PRT-05',
                'title' => 'Printing from your own laptop on campus',
                'summary' => 'Connect to the CPUT print queue instead of using a lab computer.',
                'steps' => [
                    'Connect your laptop to CPUT-Students wifi.',
                    'Download the print client from the IT Services page on myCPUT.',
                    'Install it and log in with your student number and password when prompted.',
                    'Print as normal, then release your job at any campus printer by tapping your student card.',
                ],
            ],

            // ---------- Passwords ----------
            [
                'category' => 'password',
                'tag' => 'PWD-01',
                'title' => 'Resetting your student password',
                'summary' => 'Self-service reset, no need to visit the Service Desk.',
                'steps' => [
                    'Go to password.cput.ac.za.',
                    'Enter your student number and registered cellphone number.',
                    'Enter the OTP sent to your phone.',
                    'Choose a new password meeting the minimum requirements.',
                ],
            ],
            [
                'category' => 'password',
                'tag' => 'PWD-04',
                'title' => 'Unlocking your account after too many attempts',
                'summary' => 'What to do if your account is temporarily locked.',
                'steps' => [
                    'Wait 15 minutes before trying again.',
                    'If still locked, use the self-service reset at password.cput.ac.za.',
                ],
            ],
            [
                'category' => 'password',
                'tag' => 'PWD-06',
                'title' => 'Changing your password before it expires',
                'summary' => 'CPUT passwords expire periodically. Here is how to update it in time.',
                'steps' => [
                    "Log into the myCPUT portal -- an expiry warning appears if you're close to the deadline.",
                    "Click 'Change Password' in your account settings.",
                    'Enter your current password, then your new password twice.',
                    'Make sure the new password meets the minimum length and complexity rules shown on screen.',
                    'Update the saved password on your phone and laptop so you stay logged in.',
                ],
            ],

            // ---------- Learning Platforms ----------
            [
                'category' => 'learning',
                'tag' => 'LMS-01',
                'title' => 'Logging into Blackboard for online classes',
                'summary' => 'Access your course material, tests, and announcements.',
                'steps' => [
                    'Go to the Blackboard link on the myCPUT student portal homepage.',
                    'Log in using your student number and myCPUT password.',
                    'Select your current modules from the course list to see class material.',
                    'If a module is missing, check with your lecturer that you are officially registered for it.',
                ],
            ],
            [
                'category' => 'learning',
                'tag' => 'LMS-02',
                'title' => 'Joining a Microsoft Teams class link',
                'summary' => 'For lecturers running live online sessions.',
                'steps' => [
                    'Click the Teams link shared by your lecturer, usually posted on Blackboard.',
                    'Choose to continue in your browser, or open the Teams app if installed.',
                    'Sign in with your full student email address and myCPUT password.',
                    'Turn your camera and microphone on or off as needed, then click Join now.',
                ],
            ],
            [
                'category' => 'learning',
                'tag' => 'LMS-03',
                'title' => 'Downloading and setting up the myCPUT mobile app',
                'summary' => 'Check your timetable, results, and notices from your phone.',
                'steps' => [
                    'Search for the official CPUT app in the App Store or Google Play.',
                    'Open the app and log in with your student number and myCPUT password.',
                    'Enable notifications so you get alerts for announcements and results.',
                ],
            ],

            // ---------- CRIMS ----------
            [
                'category' => 'crims',
                'tag' => 'CRIMS-01',
                'title' => 'Checking your marks on CRIMS',
                'summary' => 'View your continuous assessment and test marks per module.',
                'steps' => [
                    'Log into CRIMS using your student number and password.',
                    "Select the 'Assessment Marks' tab.",
                    'Choose the module you want to view from the list.',
                    'Your marks appear per assessment, with a running average at the bottom.',
                    'If a mark looks missing or incorrect, contact your lecturer directly -- this is an academic query, not an IT fault.',
                ],
            ],
            [
                'category' => 'crims',
                'tag' => 'CRIMS-02',
                'title' => 'Applying for a deferred exam or sick test on CRIMS',
                'summary' => 'Submit your application and supporting documents directly through CRIMS.',
                'steps' => [
                    'Log into CRIMS within the required timeframe, usually within 3 working days of the missed assessment.',
                    "Go to 'Deferred Exam / Sick Test Application'.",
                    'Select the module and assessment you missed.',
                    'Upload your supporting documents, such as a medical certificate.',
                    'Submit the application and note the reference number.',
                    "Track the outcome under 'My Applications' on CRIMS.",
                ],
            ],
            [
                'category' => 'crims',
                'tag' => 'CRIMS-03',
                'title' => 'Reporting a lecturer who is not attending scheduled classes',
                'summary' => 'Log a formal concern so the department can follow up -- this is not handled by the Service Desk.',
                'steps' => [
                    "Log into CRIMS and go to 'Student Queries' or 'Complaints'.",
                    'Select the module and lecturer the query relates to.',
                    'Describe the dates and details of the missed classes as clearly as possible.',
                    'Submit the query -- it is routed to the Head of Department, not IT.',
                    'Keep your reference number in case you need to follow up.',
                ],
            ],
        ];

        foreach ($guides as $data) {
            $category = Category::where('slug', $data['category'])->first();

            if (! $category) {
                continue;
            }

            $guide = Guide::create([
                'category_id' => $category->id,
                'tag' => $data['tag'],
                'slug' => Str::slug($data['title']),
                'title' => $data['title'],
                'summary' => $data['summary'],
                'status' => 'published',
                'views_count' => 0,
                'helpful_count' => 0,
                'not_helpful_count' => 0,
                'published_at' => now(),
            ]);

            foreach ($data['steps'] as $index => $stepText) {
                $guide->guideSteps()->create([
                    'step_number' => $index + 1,
                    'content' => $stepText,
                ]);
            }
        }
    }
}
