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
        'logo_url',
    ];

    /**
     * Get the game provider queues for the application.
     */
    public function gameProviderQueues()
    {
        return $this->hasMany(GameProviderQueue::class)
            ->orderBy('started_at', 'desc');
    }

    /**
     * Get the game provider queues for the application.
     */
    public function candidateGameProviderOnQueue()
    {
        return $this->hasOne(GameProviderQueue::class)
            ->orderBy('started_at', 'desc')
            ->withDefault();
    }

    /**
     * Get the game provider queues for the application.
     */
    public function activeGameProviderOnQueue()
    {
        return $this->hasOne(GameProviderQueue::class)
            ->where('is_active', true)
            ->withDefault();
    }

    /**
     * Get the game provider queues for the application.
     */
    // public function expiredGameProviderQueue()
    // {
    //     return $this->hasMany(GameProviderQueue::class)
    //         ->where('is_active', true)
    //         ->where('ended_at', '<', $this->freshTimestamp());
    // }

    /**
     * Get the game provider queues for the application.
     */
    // public function candidateGameProviderQueue()
    // {
    //    return $this->hasMany(GameProviderQueue::class)
    //        ->where('is_active', false)
    //        ->where('started_at', '<=', $this->freshTimestamp())
    //        ->where('ended_at', '>=', $this->freshTimestamp());
    // }

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
