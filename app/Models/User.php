<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Generate the user's HMAC based on the timestamp.
     *
     * @param  int  $time
     * @return string
     */
    public function generateSecret(int $time = 0): string
    {
        if (!$time) {
            $time = now()->timestamp;
        }

        return hash_hmac('whirlpool', $time, $this->getAttribute('secret'));
    }

    /**
     * Make sure user's HMAC is valid.
     *
     * @param  string  $hash
     * @param  int  $time
     * @return bool
     */
    public function validateSecret(string $hash, int $time): bool
    {
        return hash_equals($this->generateSecret($time), $hash);
    }

    /**
     * Assign receipts to the user based on the generated hash.
     *
     * @param  array  $receipts
     * @return void
     */
    public function assignReceipts(array $receipts): void
    {
        $receiptsToUpdate = [];
        foreach ($receipts as $receipt) {
            if ($this->validateSecret($receipt['hash'], $receipt['time'])) {
                array_push($receiptsToUpdate, $receipt['hash']);
            }
        }

        Receipt::whereIn('hash', $receiptsToUpdate)->update(['user_id' => $this->getKey()]);
    }
}
