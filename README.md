# KnownApiForward
forward json POST api calls from IFTTT to your Known site

## IFTT
- create a new IFTTT recipe : if ... then Maker (Make a Web request)
- url : url to this script
- method : POST
- contentType: json
- Body {"body":"I Push my Status to my Known site","id":"YourSecretAuth", "key":"yourSecretKey"}

## Actions
The default action will be a status, but you can set the action variable to modify this.
For example 
````
{"body":"http://cool.url/","action":"like/edit";"id":"YourSecretAuth", "key":"yourSecretKey"}
```` 
This would add a new Bookmark to your site. For some entities you need to submit additionnal fields, for a post (/entry/edit) you need to submit a title too.
