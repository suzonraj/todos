<?php

namespace App\Models\Traits\Attribute;

use Auth;

/**
 * Trait TodoAttribute
 *
 * @package App\Models\Traits\Attribute
 */
trait TodoAttribute
{

    /**
     * @return string
     */
    public function getStatusLabelAttribute()
    {
        if ($this->isActive()) {
            return "<span class='badge badge-success'>".__('labels.general.active').'</span>';
        }

        return "<span class='badge badge-danger'>".__('labels.general.inactive').'</span>';
    }

    /**
     * @return string
     */
    public function getShowButtonAttribute(): string
    {
        return '<a href="'.route('admin.transaction.entries.show',
                $this).'" data-toggle="tooltip" data-placement="top" title="'.__('buttons.general.crud.view').'" class="btn btn-xs btn-flat btn-square mr-1 btn-info bg-gradient-info"><i class="fas fa-eye"></i></a>';
    }

    /**
     * @return string
     */
    public function getEditButtonAttribute(): string
    {
        if (Auth::user()->isSuperAdmin() || Auth::user()->isAdmin()) {
            return '<a href="'.route('admin.transaction.entries.edit',
                    $this).'" data-toggle="tooltip" data-placement="top" title="'.__('buttons.general.crud.edit').'" class="btn btn-xs btn-flat btn-square mr-1 btn-primary bg-gradient-primary"><i class="fas fa-edit"></i></a>';
        }

        return '';
    }


    /**
     * @return string
     */
    public function getDeleteButtonAttribute(): string
    {
        if (Auth::user()->isSuperAdmin() || Auth::user()->isAdmin()) {
            return '<a href="'.route('admin.transaction.entries.destroy', $this).'"
                 data-method="delete"
                 data-toggle="tooltip"
                 title="'.__('buttons.general.crud.delete').'"
                 data-trans-button-cancel="'.__('buttons.general.cancel').'"
                 data-trans-button-confirm="'.__('buttons.general.crud.delete').'"
                 data-trans-title="'.__('strings.backend.general.are_you_sure').'"
                 class="btn btn-xs btn-flat btn-square mr-1 btn-danger bg-gradient-danger"><i class="fas fa-trash"></i></a> ';
        }

        return '';
    }

    /**
     * @return string
     */
    public function getRestoreButtonAttribute(): string
    {
        if (Auth::user()->isSuperAdmin() || Auth::user()->isAdmin()) {
            return '<a href="'.route('admin.transaction.entries.restore',
                    $this).'" name="confirm_item" data-toggle="tooltip" data-placement="top" title="'.__('buttons.backend.access.patientss.restore_patients').'" class="btn btn-xs btn-flat btn-square mr-1 btn-info bg-gradient-info"><i class="fas fa-sync"></i></a>';
        }

        return '';
    }

    /**
     * @return string
     */
    public function getDeletePermanentlyButtonAttribute(): string
    {
        if (Auth::user()->isSuperAdmin() || Auth::user()->isAdmin()) {
            return '<a href="'.route('admin.transaction.entries.delete-permanently',
                    $this).'" name="confirm_item" data-toggle="tooltip" data-placement="top" title="'.__('buttons.backend.access.patientss.delete_permanently').'" class="btn btn-xs btn-flat btn-square mr-1 btn-danger bg-gradient-danger"><i class="fas fa-trash"></i></a>';
        }

        return '';
    }

    /**
     * @return string
     */
    public function getActionsAttribute(): string
    {
        return $this->show_button.
            $this->edit_button.
            $this->status_button.
            $this->delete_button;
    }
}
