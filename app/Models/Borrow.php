<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrow extends Model {
    protected $fillable = [
        'user_id', 'book_id',
        'borrowed_at', 'due_date',
        'returned_at', 'status'
    ];

    protected $casts = [
        'borrowed_at' => 'date',
        'due_date'    => 'date',
        'returned_at' => 'date',
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function book() { return $this->belongsTo(Book::class); }

    public function isOverdue(): bool {
        return $this->status === 'borrowed' && $this->due_date->isPast();
    }
}
