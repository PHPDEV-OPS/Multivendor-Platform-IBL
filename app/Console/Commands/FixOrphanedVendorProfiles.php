<?php

namespace App\Console\Commands;

use App\Models\VendorProfile;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixOrphanedVendorProfiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vendor:fix-orphaned {--fix : Fix orphaned profiles by deleting them}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Identify and optionally fix orphaned vendor profiles';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for orphaned vendor profiles...');

        // Find vendor profiles without associated users
        $orphanedProfiles = VendorProfile::whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                  ->from('users')
                  ->whereRaw('users.id = vendor_profiles.user_id');
        })->get();

        if ($orphanedProfiles->isEmpty()) {
            $this->info('✅ No orphaned vendor profiles found.');
            return 0;
        }

        $this->warn("Found {$orphanedProfiles->count()} orphaned vendor profile(s):");
        
        foreach ($orphanedProfiles as $profile) {
            $this->line("  - ID: {$profile->id}, User ID: {$profile->user_id}, Company: {$profile->company_name}");
        }

        if ($this->option('fix')) {
            if ($this->confirm('Do you want to delete these orphaned profiles?')) {
                $count = $orphanedProfiles->count();
                $orphanedProfiles->each(function ($profile) {
                    $profile->delete();
                });
                
                $this->info("✅ Deleted {$count} orphaned vendor profile(s).");
            } else {
                $this->info('Operation cancelled.');
            }
        } else {
            $this->info('Use --fix option to delete orphaned profiles.');
        }

        return 0;
    }
}
