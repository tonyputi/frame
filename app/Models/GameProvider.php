<?php

namespace App\Models;

use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GameProvider extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'location_modifier', 'location_match', 'default_host'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'logo_url'
    ];

    /**
     * Get all the bookings history for that provider
     *
     * @return HasMany
     */
    public function bookings()
    {
        return $this->hasMany(GameProviderQueue::class)
            ->orderBy('started_at', 'asc');
    }

    /**
     * Get all the new booking history for that provider
     *
     * @return HasMany
     */
    public function nextBookings()
    {
        return $this->bookings()
            ->available()
            ->active(false);
    }

    /**
     * Get the next booking for that provider
     *
     * @return HasMany
     */
    public function nextBooking()
    {
        return $this->hasOne(GameProviderQueue::class)
            ->available()
            ->active(false)
            ->orderBy('started_at', 'asc');
    }

    /**
     * Get the current booking for that provider
     *
     * @return HasMany
     */
    public function currentBooking()
    {
        return $this->hasOne(GameProviderQueue::class)
            ->whereRaw("? BETWEEN started_at AND ended_at", [$this->freshTimestamp()->toIso8601String()])
            ->active(false)
            ->orderBy('started_at', 'asc');
    }

    /**
     * Get the game provider queues for the application.
     */
    public function expiredBookings()
    {
        return $this->hasMany(GameProviderQueue::class)
            ->active(true)
            ->expired();
    }

    /**
     * Update the game provider logo.
     *
     * @param  \Illuminate\Http\UploadedFile  $logo
     * @return void
     */
    public function updateLogo(UploadedFile $logo)
    {
        tap($this->logo_path, function ($previous) use ($logo) {
            $this->forceFill([
                'logo_path' => $logo->storePublicly(
                    'game-provider-logos', ['disk' => 'public']
                ),
            ])->save();

            if ($previous) {
                Storage::disk('public')->delete($previous);
            }
        });
    }

    /**
     * Delete the game provider logo.
     *
     * @return void
     */
    public function deleteLogo()
    {
        Storage::disk('public')->delete($this->logo_path);

        $this->forceFill([
            'logo_path' => null,
        ])->save();
    }

    /**
     * Get the URL to the user's profile photo.
     *
     * @return string
     */
    public function getLogoUrlAttribute()
    {
        return $this->logo_path
            ? Storage::disk('public')->url($this->logo_path)
            : $this->defaultLogoUrl();
    }

    /**
     * Get the default profile photo URL if no profile photo has been uploaded.
     *
     * @return string
     */
    protected function defaultLogoUrl()
    {
        return 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&color=7F9CF5&background=EBF4FF';
    }
}
