const fs = require('fs');
const path = require('path');
const newDir = 'D:/' + path.basename(__dirname);
console.log('start')

fs.cp(__dirname, newDir,
    { filter: check, recursive: true },
    (err) => {
        if (err) {
            console.error(err);
        }
    }
);
//copy directory
// fs.cp(__dirname, newDir, { filter:check,recursive: true }, (err) => {
//   if (err) {
//     console.error(err);
//     }

// });
console.log('finish');
function check(src, dest) {
    let toCopy = true;
    const search = [
        // folder 
        'node_modules',
        // files 
        'ready.js',
        'copy.js',
        'loader.js',
        'package.json',
        'package-lock.json',
        'index.js',
        '.jsx',
        'uninstall.php',

    ];
    for (const word of search) {

        if (src.includes(s)) {
            toCopy = false;
            break;
        }
    }
    // search.forEach(s => {
    // });
    return toCopy;

}