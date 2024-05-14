<?php

namespace App\Models\Ticket;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use function Assert\thatNullOr;

class Ticket extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = ['user_id' , 'subject' , 'description' , 'seen' , 'reference_id' , 'category_id' , 'priority_id' , 'ticket_id'];


    public function user ()
    {
        return $this->belongsTo(User::class , 'user_id' );
    }

    public function admin ()
    {
        return $this->belongsTo(TicketAdmin::class , 'reference_id' );
    }

    public function priority ()
    {
        return $this->belongsTo(TicketPriority::class , 'priority_id' );
    }

    public function category ()
    {
        return $this->belongsTo(TicketCategory::class , 'category_id' );
    }

    public function parent()
    {
        return $this->belongsTo($this , 'ticket_id')->with('parent');
    }

    public function children()
    {
        return $this->hasMany($this , 'ticket_id')->with('children');
    }

    public function file () {
        return $this->hasOne(TicketFile::class);
    }

}
