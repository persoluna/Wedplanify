<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Inquiry;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InquiryPolicy
{
    use HandlesAuthorization;

    public function before(User $authUser): ?bool
    {
        if ($authUser->hasRole('super_admin')) {
            return true;
        }

        return null;
    }

    public function viewAny(User $authUser): bool
    {
        if ($authUser->isAdmin()) {
            return $authUser->can('ViewAny:Inquiry');
        }

        return $authUser->isAgency() || $authUser->isVendor();
    }

    public function view(User $authUser, Inquiry $inquiry): bool
    {
        if ($authUser->isAdmin()) {
            return $authUser->can('View:Inquiry');
        }

        return $this->canAccessInquiry($authUser, $inquiry);
    }

    public function create(User $authUser): bool
    {
        if ($authUser->isAdmin()) {
            return $authUser->can('Create:Inquiry');
        }

        return $authUser->isAgency();
    }

    public function update(User $authUser, Inquiry $inquiry): bool
    {
        if ($authUser->isAdmin()) {
            return $authUser->can('Update:Inquiry');
        }

        return $this->canAccessInquiry($authUser, $inquiry);
    }

    public function delete(User $authUser, Inquiry $inquiry): bool
    {
        if ($authUser->isAdmin()) {
            return $authUser->can('Delete:Inquiry');
        }

        return $this->canAccessInquiry($authUser, $inquiry);
    }

    public function restore(User $authUser, Inquiry $inquiry): bool
    {
        return $authUser->can('Restore:Inquiry')
            && $this->canAccessInquiry($authUser, $inquiry);
    }

    public function forceDelete(User $authUser, Inquiry $inquiry): bool
    {
        return $authUser->can('ForceDelete:Inquiry')
            && $this->canAccessInquiry($authUser, $inquiry);
    }

    public function forceDeleteAny(User $authUser): bool
    {
        return $authUser->isAdmin()
            && $authUser->can('ForceDeleteAny:Inquiry');
    }

    public function restoreAny(User $authUser): bool
    {
        return $authUser->isAdmin()
            && $authUser->can('RestoreAny:Inquiry');
    }

    public function replicate(User $authUser, Inquiry $inquiry): bool
    {
        return $authUser->can('Replicate:Inquiry')
            && $this->canAccessInquiry($authUser, $inquiry);
    }

    public function reorder(User $authUser): bool
    {
        return $authUser->isAdmin()
            && $authUser->can('Reorder:Inquiry');
    }

    private function canAccessInquiry(User $authUser, Inquiry $inquiry): bool
    {
        if ($authUser->isAgency()) {
            $agency = $authUser->agency;

            if (! $agency) {
                return false;
            }

            return (int) $inquiry->agency_id === (int) $agency->getKey();
        }

        if ($authUser->isVendor()) {
            $vendor = $authUser->vendor;

            if (! $vendor) {
                return false;
            }

            return (int) $inquiry->vendor_id === (int) $vendor->getKey();
        }

        return $authUser->isAdmin();
    }
}
