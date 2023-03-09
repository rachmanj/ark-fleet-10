<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HazardReport extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function employee()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'to_department_id', 'id');
    }

    public function attachments()
    {
        return $this->hasMany(ReportAttachment::class, 'hazard_report_id', 'id');
    }

    public function responses()
    {
        return $this->hasMany(HazardResponse::class, 'hazard_report_id', 'id');
    }

    public function danger_types()
    {
        return $this->belongsToMany(DangerType::class, 'hazard_report_danger_type', 'hazard_report_id', 'danger_type_id');
    }
}
