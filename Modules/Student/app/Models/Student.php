<?php
namespace Modules\Student\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Student extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected static function newFactory()
    {
        return \Modules\Student\Database\Factories\StudentFactory::new();
    }

    protected $fillable = ['name', 'grade', 'subject', 'contact_number'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'grade', 'subject', 'contact_number'])
            ->logOnlyDirty()
            ->dontLogEmptyChanges();
    }
}