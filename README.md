# Favourites

Snippet to manage the list of favourite items.

## Usage

If you are satisfied with default values and js scripts, then rename "ajax.php.example" file to "ajax.php". Or write your own ones.

### Generic parameters
* controller - the name of controller class, default is Pathologic\Favourites\Actions;
* model - the name of model class, default is Pathologic\Favourites\Model;
* includeJs - set to 1 to load default js-scripts;
* cookieName - the name of the cookie to store favourite items, default is "favourites";
* action - the name of controller method to act (they are "add", "remove", "count", "listItems" by default);
* id - id of the document to add or remove;
* snippetName - the name of the snippet to list items (DocLister by default);
* addTpl, removeTpl - see the example below.

### Displaying the number of items:
```
<a href="[~100~]" title="Favourites"><i class="fa fa-heart"></i> Favourites: <span class="favourites-count">[!Favourites? &action=`count`!]</span></a>
```
The "favourites-count" class is used to update items counter when add or remove button is pressed.

### Checking if there's an item in the list (tpls are default here):
```
[!Favourites? &action=`check` &addTpl=`@CODE:<a class="btn favourites" data-id="[+id+]" href="#"><i class="fa fa-heart"></i> Favourite</a>` &removeTpl=`@CODE:<a class="btn favourites active" data-id="[+id+]" href="#"><i class="fa fa-heart"></i> Favourite</a>`!]
```
The "favourites" class is needed for default js as well as "data-id" attribute. 

### Displaying the list of items:
```
[!Favourites
&action=`listItems`
&snippetName=`DocLister`
&sortType=`doclist`
&tpl=`itemTpl`
!]
```

