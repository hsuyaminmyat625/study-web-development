for (var i = 0; i < 101; i++) {
    if (i % 3 ) {
        console.log("Fizz");
    }
    else if (i % 5) {
        console.log("Buzz");
    } 
    else if (i % 15) {
        console.log("FizzBuzz");
    } 
    else {
        console.log(i);
    }
}

