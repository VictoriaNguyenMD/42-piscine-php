# Periodic Table of Elements

<img src="Periodic_Table_of_Elements.png" alt="Periodic Table of Elements">

This project is similar to Exercise 01; however, the table needs to be responsive to browser resizing (when you make the page smaller and larger by dragging the corners in).

Create a webpage that represents Dimitri Mendeleïev complete periodic table of the
elements (the current version). The constraints are as follows:
- [x] Contain at least one image for embellishment
- [x] Beautiful design (eg. colors)
- [x] Each box in the periodic table contains: atomic number (lower left), element (middle), and atomic weight (top right)
- [x] The information seen in the table must be in a modifiable text 

Added Features
- [x] The periodic table and fonts shrink when you resize the browser
- [x] Separated the files into `responsive.css` and `responsive.html`

## Running the code

**1. Git clone the repository in your terminal**

      `git clone https://github.com/VictoriaNguyenMD/42-piscine-php.git`

**2. Move into the repository**

      `cd d00/ex01`

**3. Open the file in your browser**

First try: 

      `open -a "Google Chrome" mendeleive.html`

If this fails, `pwd` in your terminal to get the location of the file. In your browser, type `file:///` and the information gathered from the `pwd`.

## Additional Notes
Since you are linking `responsive.css` in the `responsive.html` folder, it is possible to separate the files. If the folders are different, you need to put the path to the `.css` file.

For example:

`<link rel="stylesheet" type="text/css" href="Folder1/Folder2/file_name.css">`