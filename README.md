## Eat.is application for Kohana 3.0

This is complete application for kohana framework version 3 allowing people to find some places by distance, food types, categories, price range, etc. You can get directions to place, read its review and even rate it.

### Requirements

* [Database module](http://github.com/kohana/database)
* [ORM module](http://github.com/kohana/orm)
* [Smarty module](http://github.com/MrAnchovy/kohana-module-smarty)
* [Minify module](http://github.com/ryross/minify)
* [Pagination module](http://github.com/kohana/pagination)
* [Latest stable Kohana 3](http://github.com/kohana/kohana)
* MySQL Database for a couple of tables

### Installation

1. Clone latest stable kohana repository.
2. Make sure you have the required modules mentioned above.
3. Update all submodules.
4. Import __database.sql__ to new database in your favourite SQL editor.
5. Rename __eat_is.example.php__ to __eat_is.php__ and change it to your specs.
6. Rename __database.example.php__ to __database.php__ and write correct values.
7. Create __media__ and __minify__ in cache folder, chmod to 0777.

### Copyright

The Eat.is application is copyright 2010 by following authors:

* Birkir R Gudjonsson http://birkir.forritun.org email birkir.gudjonsson@gmail.com
* Odinn Thrainsson http://maniac.is email odinnt@gmail.com

If you are seeing this, you some how entered our servers or git repository. Because we are cool, we dont give a __crap__ if you take the source code, so be our guest. Our plan was to have it open source but not distribute it, that way we have it for our self as long as we dont distribute it.

Kohana is copyright 2008-2009 Kohana Team http://kohanaframework.com/license.html

The Eat.is application for Kohana is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program. If not, see http://www.gnu.org/licenses/
