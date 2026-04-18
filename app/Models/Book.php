<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model {
    protected $fillable = [
        'title', 'author', 'isbn', 'category',
        'description', 'cover_image',
        'total_copies', 'available_copies'
    ];

    public function borrows() {
        return $this->hasMany(Borrow::class);
    }

    public function isAvailable(): bool {
        return $this->available_copies > 0;
    }

    public function isBorrowedBy($userId): bool {
        return $this->borrows()
            ->where('user_id', $userId)
            ->where('status', 'borrowed')
            ->exists();
    }
}
