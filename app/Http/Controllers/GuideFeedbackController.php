<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuideFeedbackStoreRequest;
use App\Models\GuideFeedback;
use Illuminate\Http\RedirectResponse;

class GuideFeedbackController extends Controller
{
    public function store(GuideFeedbackStoreRequest $request): RedirectResponse
    {
        $feedback = GuideFeedback::create($request->validated());

        // Different flash message depending on which button the student
        // clicked -- read back on the guide.show view to confirm their choice.
        $message = $feedback->is_helpful
            ? 'Glad it helped. Thanks for the feedback.'
            : "Sorry that didn't sort it. Please contact the Service Desk with your student number handy.";

        return back()->with('feedback_message', $message)
            ->with('feedback_was_helpful', $feedback->is_helpful);
    }
}
