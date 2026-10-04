<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * departments.head used to be saved as the user's name by the create form and as the
 * user's id by the edit form. Normalize every row to the user id; names that don't
 * match exactly one user are cleared so the department shows "No head assigned".
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::table('departments')->whereNotNull('head')->orderBy('id')->each(function ($department) {
            if (ctype_digit((string) $department->head)) {
                return;
            }

            $matches = DB::table('users')->whereRaw('LOWER(name) = ?', [strtolower(trim($department->head))])->pluck('id');

            DB::table('departments')->where('id', $department->id)->update([
                'head' => $matches->count() === 1 ? (string) $matches->first() : null,
            ]);
        });
    }

    public function down(): void
    {
        // Ids are the intended format; there is nothing to restore.
    }
};
