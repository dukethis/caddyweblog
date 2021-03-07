# caddy weblog
Minimalist weblog (single user)

## Structure

This is a minimalist full-php weblog generator. 

### /index.php

Index page serves every logs stored in *data.json* data tree.

### /new.php

Serves the new log form which allows to create a new publication providing :
- a publication date (default is the current date)
- an author name
- a title
- a markdown formatted content

### /weblog.php

Backend script which generates the final page using caddy's markdown library to parse markdown to HTML. The following is used to achieve the transcription in .php files :
```
{{ include "/path/to/file.md" | markdown }}

{{ "### The End" | markdown }}
```
The result for the last caddy server instruction would be seen as :
### The End
