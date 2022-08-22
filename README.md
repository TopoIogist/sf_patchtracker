## Overview

This is a small site which tracks patches on fishtest and allows to display
curves of lost/won games to visualize how a patch progresses through fishtest.

## Files

This project consists of the following files:

  * [README.md],
    the file you are currently reading.

  * [LICENSE.md]
    a text file containing the GNU General Public License version 3.

  * [backend],
    a subdirectory containing two python scripts, which run as a cronjob
    on a backend server. They will scrape fishtest for running patches
    and mirror the data to a mysql database which has to be setup.
    The simplify script will occasionally remove some data points to
    assert that the table does not grow too quickly (should be only
    about 30MB per month).

  * [frontend]
    a subdirectory containing the frontend files which should run on
    a webserver with php support.
    

## Terms of use

This software is free, and distributed under the **GNU General Public License version 3**
(GPL v3). Essentially, this means you are free to do almost exactly
what you want with the program, including distributing it among your
friends, making it available for download from your website, selling
it (either by itself or as part of some bigger software package), or
using it as the starting point for a software project of your own.

The only real limitation is that whenever you distribute this software in
some way, you MUST always include the license and the full source code
(or a pointer to where the source code can be found) to generate the 
exact binary you are distributing. If you make any changes to the
source code, these changes must also be made available under the GPL v3.

For full details, read the copy of the GPL v3 found in the file named
[*LICENSE.md*]
