// List of Greek areas
var greekAreas = [
    "Πετρούπολης",
    "Γέρακα",
    "Περιστερίου",
    "Ηράκλειου",
    "Καλλιθέας"
  ];
  
  // Function to generate a random Greek school name
  function generateRandomGreekSchoolName() {
    var randomNumber = Math.floor(Math.random() * 20) + 1;
    var randomSchoolType = getRandomSchoolType();
    var randomArea = greekAreas[Math.floor(Math.random() * greekAreas.length)];
    
    return randomNumber + " " + randomSchoolType + " " + randomArea;
  }
  
  // Function to get a random school type
  function getRandomSchoolType() {
    var schoolTypes = ["Γυμνάσιο", "Λύκειο", "Δημοτικό"];
    var randomIndex = Math.floor(Math.random() * schoolTypes.length);
    return schoolTypes[randomIndex];
  }
  
  // Usage example
  var randomGreekSchoolName = generateRandomGreekSchoolName();
  console.log(randomGreekSchoolName);
  