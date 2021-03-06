'use strict';

// Async
// var spawn       = require('child_process').spawn;

// Sync
var spawn       = require('child_process').spawnSync;
var parser      = require('http-string-parser');

// Timer
var start = process.hrtime();

var elapsed_time = function(note){

  var precision = 3; // 3 decimal places
  var elapsed = process.hrtime(start)[1] / 1000000; // divide by a million to get nano to milli

  console.log('Time: ' + elapsed.toFixed(precision) + "ms - " + note); // print message + time

  start = process.hrtime(); // reset the timer
}

exports.handler = function(event, context) {

    console.log("Request: " + JSON.stringify(event));

    // Sets some sane defaults here so that this function doesn't fail when it's not handling a HTTP request from
    // API Gateway.
    var requestMethod = event.httpMethod || 'GET';
    var serverName    = event.headers ? event.headers.Host : '';
    var requestUri    = event.path || '';
    var headers       = {};
    var httpObject    = {};

    // Convert all headers passed by API Gateway into the correct format for PHP CGI. This means converting a header
    // such as "X-Test" into "HTTP_X-TEST".
    if (event.headers) {
        Object.keys(event.headers).map(function (key) {
            headers['HTTP_' + key.toUpperCase()] = event.headers[key];
        });
    }

    // Get function name. This will have a suffix with environment
    // var environment = context.functionName.split('_').slice(-2);
    var environment = context.functionName.slice(-3);
    console.log("Environment: " + JSON.stringify(environment));

    var stage = event.requestContext.stage;

    elapsed_time("Creating HTTP object");

    // Create HTTP object
    httpObject = Object.assign({
        REDIRECT_STATUS: 200,
        REQUEST_METHOD: requestMethod,
        SCRIPT_FILENAME: 'src/v1/public/index.php',
        SCRIPT_NAME: '/src/v1/public/index.php',
        PATH_INFO: '/',
        SERVER_NAME: serverName,
        SERVER_PROTOCOL: 'HTTP/1.1',
        REQUEST_URI: requestUri,
        AWS_REGION: process.env.AWS_REGION,
        AWS_ACCESS_KEY_ID: process.env.AWS_ACCESS_KEY_ID,
        AWS_SECRET_ACCESS_KEY: process.env.AWS_SECRET_ACCESS_KEY,
        AWS_SESSION_TOKEN: process.env.AWS_SESSION_TOKEN,
        EVENT_PARAMS: JSON.stringify(event),
        BODY_JSON: event.body,
        CONTEXT_PARAMS: JSON.stringify(context),
        ENVIRONMENT: environment, // dev/prd
        STAGE: stage // green/blue
    }, headers);

    function serialize( obj ) {
        return Object.keys(obj).reduce(function(a,k){a.push(k+'='+encodeURIComponent(obj[k]));return a},[]).join('&')
    }

    if ( event.queryStringParameters && event.queryStringParameters !== null ) {
        console.log("Serialize querystring");
        httpObject.QUERY_STRING = serialize(event.queryStringParameters);
    }

    elapsed_time("Starting PHP");

    console.log("Spawning PHP...");

    // Sync
    var child = spawn('./bin/php-cgi', ['-dextension=bin/phalcon.so','src/v1/public/index.php'], {
      env: httpObject
    });

    elapsed_time("Ended PHP");

    console.log('PHP exited with status %d', child.status);

    var PHPOutput = child.stdout.toString('utf-8');

    // Parses a raw HTTP response into an object that we can manipulate into the required format.
    var parsedPHPOutput = parser.parseResponse(PHPOutput);

    var response = {
        statusCode: parsedPHPOutput.statusCode || 200,
        headers: parsedPHPOutput.headers,
        body: parsedPHPOutput.body
    };

    elapsed_time("Created AWS API request");

    console.log("response: " + JSON.stringify(response));
    context.succeed(response);

  // Async
    /*
    // Spawn the PHP CGI process with a bunch of environment variables that describe the request.
    var php = spawn('./bin/php-cgi', ['-dextension=bin/phalcon.so','src/v1/public/index.php'], {
        env: httpObject
    });

    php.stdout.on('data', function(data) {
        console.log("php.stdout.on");
        PHPOutput += data.toString('utf-8');
    });

    //react to potential errors
    php.stderr.on('data', function(data) {
        console.log("php.stderr.on");
        PHPOutput += data.toString('utf-8');
    });

    php.on('close', function() {

        console.log("php.on.close");

        // Parses a raw HTTP response into an object that we can manipulate into the required format.
        var parsedPHPOutput = parser.parseResponse(PHPOutput);

        var response = {
            statusCode: parsedPHPOutput.statusCode || 200,
            headers: parsedPHPOutput.headers,
            body: parsedPHPOutput.body
        };

        console.log("response: " + JSON.stringify(response));
        context.succeed(response);

    });*/



};
