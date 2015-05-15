# FileList library

Easily manage lists of files attached to any object in your application

**PLEASE READ**: This package is no longer maintained, and replaced by a better implementation. Please check out FileSpace instead:
[http://github.com/linkorb/filespace](http://github.com/linkorb/filespace)

## How does it work:

First, you need to instantiate a `driver`. The driver allows you to chose where your files will be physically stored.
The simplest driver is the `FileSystemDriver`. You can instantiate it like this:

```php
$driver = new LinkORB\Component\FileList\Driver\FileSystemDriver("/data/myfilelists/");
```

Second, you define a `key` for your new file-list. Here are some examples:

* `user.joe.contracts`: This would store all contracts for a user called "joe"
* `project.42.scans`: Here you would store all scans for a project with id "42"
* `post.99.downloads`: Attach a list of downloads to a post with id "99"

... and so on. It's up to you and your app to choose these keys. They don't need to exist anywhere, or be registered. It will just work.

Now that you've chosen a `key` for your list, you can retrieve your filelist instance:

```php
$filelist = $driver->getFileListByKey('user.joe.contracts');

echo "Attached files: " . $filelist->getFileCount();
```

Using the filelist instance, you can easily add, remove, and list files:

```php

// Upload a local file to the filelist, and give it a name:
$filelist->upload("/tmp/myphoto.png", "avatar.png");

// List all files on the filelist:
foreach($filelist->getFiles() as $file) {
    echo "File: " . $file->getFilename() . "\n";
}

// Download the file back from the filelist to a local directory:
$filelist->download("/home/photo.png", "avatar.png");

// Delete the file from the filelist:
$filelist->delete("avatar.png");
```

## Benefits

One of the benefits of using FileList vs regular files, is that you can swap storage backends.

It's quick and simple to write to files in directories directly, but as your application grows, you may want to start storing that data remotely in S3, GridFS, etc...

Using the FileList library, this becomes a simple matter of attaching a different driver.
For example, you can use the [objectstorage](http://www.github.com/linkorb/objectstorage) library to easily store your content in S3, GridFs, PDO etc.


## Console tool

This library comes with a simple console application that uses the library.
You can use it for testing and introspection.

### Example console commands:

    # Upload a file to a filelist
    bin/console filelist:upload user.joe.photos /home/test/avatar.png

    # Download a file from a filelist
    bin/console filelist:download user.joe.photos avatar.png /home/test/output.png

    # List files on a filelist
    bin/console filelist:list user.joe.photos

    # Delete data from object storage
    bin/console filelist:delete user.joe.photos avatar.png

### Configuration file

The console tool can be configured using a configuration file.

It will look for a file called `filelist.conf` in the current directory. 
Alternatively it will look for `~/.filelist.conf` and finally for `/etc/filelist.conf`.

You can also specify a config file explicity by using the option `--config myconfig.conf`

### Example config file:

This repository contains a file called `filelist.conf.dist` which you can use to copy to `filelist.conf` and add your own configuration. The comments in this file explain what options are available.

## Features

* PSR-0 compatible, works with composer and is registered on packagist.org
* PSR-1 and PSR-2 level coding style
* List, Upload, Download, Delete, Get and Set commands.
* Included with command line utility for testing and introspection

## Todo (Pull-requests welcome!)

* Integrate github.com/linkorb/objectstorage for S3, GridFs, PDO support

## Installing

Check out [composer](http://www.getcomposer.org) for details about installing and running composer.

Then, add `linkorb/objectstorage` to your project's `composer.json`:

```json
{
    "require": {
        "linkorb/filelist": "dev-master"
    }
}
```

## Contributing

Ready to build and improve on this repo? Excellent!
Go ahead and fork/clone this repo and we're looking forward to your pull requests!

If you are unable to implement changes you like yourself, don't hesitate to
open a new issue report so that we or others may take care of it.

## License

Please check LICENSE.md for full license information

## Brought to you by the LinkORB Engineering team

<img src="http://www.linkorb.com/d/meta/tier1/images/linkorbengineering-logo.png" width="200px" /><br />
Check out our other projects at [linkorb.com/engineering](http://www.linkorb.com/engineering).

Btw, we're hiring!
