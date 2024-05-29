const http = require('http');
const url = require('url');
const path = require('path');
const fs = require('fs');


const server = http.createServer((req, res) => {
    const parsedUrl = url.parse(req.url, true);
    // let pathname = path.join(__dirname, '../frontend/Login', parsedUrl.pathname);
    let pathname = `.${parsedUrl.pathname}`;
    
    // if (pathname === path.join(__dirname, '../frontend/Login/')) {
    //     pathname = path.join(__dirname, '../frontend/Login/LoginPage.html');
    // }
    if(pathname === './login'){
        pathname = '../frontend/Login/LoginPage.html';
    } else if(pathname === './dashboard'){
        pathname = '../frontend/Login/DashboardLogin.html';
    } else {
        pathname = path.join(__dirname, '../frontend/Login/',pathname);
    }

    const ext = path.parse(pathname).ext;
    const map = {
        '.html': 'text/html',
        '.css': 'text/css',
        '.js': 'text/javascript',
        '.png': 'image/png',
        '.jpg': 'image/jpeg',
        '.jpeg': 'image/jpeg',
        '.mp4': 'video/mp4'
    };

    fs.access(pathname, fs.constants.F_OK, (err) => {
        if (err) {
          res.statusCode = 404;
          res.setHeader('Content-Type', 'text/plain');
          res.end('404 Not Found\n');
          return;
        }
    
        res.statusCode = 200;
        res.setHeader('Content-Type', map[ext] || 'text/plain');
        fs.createReadStream(pathname).pipe(res);
      });
    });

    const port = 3000;
    server.listen(port, () => {
        console.log(`Server running at http://localhost:${port}/`);
    });
