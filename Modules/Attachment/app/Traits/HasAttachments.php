<?php

namespace Modules\Attachment\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Attachment\Models\Attachment;

trait HasAttachments
{
    // Any model using this trait can call ->attachments to get all its files
    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}