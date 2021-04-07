USE framboises;

-- generate default user
-- change password on first login (default is Pa$$w0rd)

INSERT INTO users (username,email,password)
    VALUES ('admin','admin@framboises-mathod.ch','$2y$10$qfWeZX7coS3jVyF/A2h2yu2XUiJ/2gltyM2kkWxeUQaJsOwylhq9C')

-- Generate default roles

INSERT INTO roles (name)
    VALUES ('administrator'),('editor');

-- Add administrator role to admin
-- TODO use joins to avoid using id
INSERT INTO users_possesses_roles (users_id, roles_id)
    VALUES (1,1);