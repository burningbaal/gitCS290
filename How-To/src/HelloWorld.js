var readline = require('readline');

var readerl = readline.createInterface({
	input: process.stdin,
	output: process.stdout
});

var things = {stuff: 'thingsAndStuff', foo: 'bar', bat: 123};
console.log('This is the %s stuff: %j', 'right', things);

readerl.question("Is this tutorial helpful?", function(answer)  {
	things.foo = answer;
	console.log('This is the %s stuff: %j', 'right', things);
	readerl.close();
});

console.log("I'm asyncronous");
