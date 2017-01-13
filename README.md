# Enbekon - Ninja Forms THREE Update

----

> Load ninja forms pre init

User Profile Information is available as merge tags in the builder.
For example, the default value can be set as `{user:display_name}`.
This will prepopulate a particular field with the users' displayname, if they are logged in.

----

> Set custom values in ninja forms from database

For default values that are not available as merge tags, there is the `ninja_forms_render_default_value` filter.

----

> Preprocess - check data before processing data and display errors
> Postproces after successful payment
> Postprocess after successful regular submit

Pre-Processing and Post-Processing have been mostly replaced by Form Actions.
Actions are configurable form processing; This transition started in v2.9.x.

Instead of hard coding field IDs in custom code, Form Actions are setup to map fields inside of the builder.

----
