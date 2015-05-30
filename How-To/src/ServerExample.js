var http = require('http');

var server = http.createServer(function(req, res) {
  res.writeHead(200);
  res.end('Hello Http');
});
server.listen(8080);

console.log('Server running at http://127.0.0.1:8124/');
console.log('Press ctrl+c to exit server');