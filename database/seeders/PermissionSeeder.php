<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'dashboard.index',
            
            'user.index', 'user.create', 'user.edit', 'user.delete',
            'role.index', 'role.create', 'role.edit', 'role.delete',
            
            'service.index', 'service.create', 'service.edit', 'service.delete',
            'sp-content.index', 'sp-content.create', 'sp-content.edit', 'sp-content.delete',
            
            'portfolio.index', 'portfolio.create', 'portfolio.edit', 'portfolio.delete',
            'pcategory.index', 'pcategory.create', 'pcategory.edit', 'pcategory.delete',
            
            'blog.index', 'blog.create', 'blog.edit', 'blog.delete',
            'bcategory.index', 'bcategory.create', 'bcategory.edit', 'bcategory.delete',
            
            'case-study.index', 'case-study.create', 'case-study.edit', 'case-study.delete',
            'testimonial.index', 'testimonial.create', 'testimonial.edit', 'testimonial.delete',
            'partner.index', 'partner.create', 'partner.edit', 'partner.delete',
            'pricing-plan.index', 'pricing-plan.create', 'pricing-plan.edit', 'pricing-plan.delete',
            'team-member.index', 'team-member.create', 'team-member.edit', 'team-member.delete',
            'faq.index', 'faq.create', 'faq.edit', 'faq.delete',
            
            'about.index', 'about.update',
            'step.index', 'step.create', 'step.edit', 'step.delete',
            
            'content-text.index', 'content-text.create', 'content-text.edit', 'content-text.delete',
            'tag.index', 'tag.create', 'tag.edit', 'tag.delete',
            
            'social-media.index', 'social-media.create', 'social-media.edit', 'social-media.delete',
            'contact.index', 'contact.delete',
            'company.index', 'company.update',
            
            'message.index', 'message.delete',
            'banner.index', 'banner.create', 'banner.edit', 'banner.delete',
            'submission.index', 'submission.delete',
            
            'settings.index', 'settings.edit',
            'telegram.index', 'telegram.edit',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission],
                ['title' => $permission]
            );
        }

        // Create super-admin role and assign all permissions
        $role = Role::firstOrCreate(
            ['name' => 'super-admin'],
            ['title' => 'Super Admin']
        );
        $role->givePermissionTo(Permission::all());
    }
}
