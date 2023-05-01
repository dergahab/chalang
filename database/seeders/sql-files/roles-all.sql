INSERT INTO `roles` (`id`, `title`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'super-admin', 'web', '2022-05-09 23:47:26', NULL),
(2, 'Admin', 'admin', 'web', '2022-05-10 21:29:02', '2022-05-10 21:29:02');

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1);
-- (2, 'App\\Models\\User', 2);


INSERT INTO `permissions` (`id`, `title`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'roles.index', 'roles.index', 'web', NULL, NULL),
(2, 'roles.create', 'roles.create', 'web', NULL, NULL),
(3, 'roles.edit', 'roles.edit', 'web', NULL, NULL),
(4, 'roles.destroy', 'roles.destroy', 'web', NULL, NULL);

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
                                                (1, 1),
                                                (2, 1),
                                                (3, 1),
                                                (4, 1);
