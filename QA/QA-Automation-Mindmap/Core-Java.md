## Core Java
- This document contains all information related to any questions that can be asked about common java topics. 
#

#### Variable, Field, Attribute, Property 
- Variable is the name given to a memory location. The basic unit of storage in a program.
- Field is a data member of a class. Can be public static, non-static, and final.
- Attribute is another term for a field. Typically a public field that can be accessed directly. 
- Property is also used for fields and it typically has a getter and setter combination. 

#
#### Primitive Data Types
- boolean 
- byte 
- char 
- short 
- int 
- long 
- float
- double

#
#### Wrapper Classes
- A Wrapper class is a class whose object wraps or contains a primitive data types.

- They convert primitive data types into objects. Objects are needed if we wish to modify the arguments passed into a method (because primitive types are passed by value). 

- Wrapper classes: 
    - Boolean
    - Byte 
    - Character 
    - Short
    - Integer
    - Long
    - Float
    - Double

#
#### Java Data Structures / Java Collections Framework
- The Java Collections Framework provides several classes and interfaces to represent a group of objects as a single unit. This collection is stored in java.util.Collection and java.util.Map packages.

- The benefits of using this collection framework are that it contains a consistent api (contains most common methods), reduces programming effort (no need to reinvent the wheel), and increases performance (by giving high-performance implementations of useful data structures and algorithms)

- The collections framework contains these interfaces:
    - List
    - Set
    - Queue
    - Dequeue
    - Map

- Types of collections:
    - ArrayList (not-synchronized)
    - LinkedList
    - Stack
    - Vector (synchronized)
    - HashSet
    - LinkedHashSet
    - PriorityQueue
    - HashMap
    - HashTable (synchronized)
    - and many more depending on your needs.
    
    #
    #### Array

    - Arrays are objects that act as data stores that hold the same type of objects in all it's indices.
    - Index numbering starts at 0 and the size of the array must be specified with an int. 

    - Once the size of an array has been set, it cannot be changed. 

    - Pros
        - Easy to create, easy to use.
        - Every other data structure is built on top of an array, which adds computation time. This is the fastest data structure.

    - Cons
        - Slow sorting, searching, and deletion

    - While it is possible to declare an array as: 
        ```
        int arrayOfInts[]
        ```

        the preferred way of declaring a one-dimensional array is:

        ```
        type[] varName; 
        int[] arrayOfInts;
        long[] arrayOfLongs;
        CustomType[] arrayOfCustomType; 
        ```
        The above is the preferred way because as we read English left to right, we can quickly see that the following variable name is holding an array of whatever type.

    - Initializing a one-dimensional array:
        ```
        // Template
        type[] varName = new type[size];

        // In two lines with the declaration on the first line and assigning on the second.
        int[] intArray;
        intArray = new int[20];

        // Declaring and assigning in one line.
        int[] arrayOfInts = new int[20];

        // Declaring, assigning, and inserting data into an array in one line.
        int[] anotherIntArray = new int[] { 1, 2, 3, 4, 5, 9, 125, 358, 4322 };
        ```
    
    - Initializing a two-dimensional array: (Think of this as a table with columns and rows)
        ```
        // The size does not have to be the same on both dimensions.
        // Template
        type[][] varName = new type[size][size];

        int[][] intArray;
        intArray = new int[10][10];

        // OR we can set the sizes of the dimensions of the array to a different number on each.
        intArray = new int[15][4];

        // Declaring and assigning in one line.
        byte[][] arrayOfBytes = new byte[32][64];
        ```

    - Assigning a new element in an array:
        ```
        int[] intArray = new int[5];
        intArray[0] = 4;
        intArray[1] = 3; 

        for(int i = 0; i < intArray.length; i++) {
            System.out.print(" " + intArray[i])
        } // Prints 4 3
        ```
    - Accessing an element in an array:
        ```
        int[] intArray = new int[] { 1, 3, 5, 7, 9 };
        intArray[0] // Returns 1
        intArray[3] // Returns 7
        ```

    - Trying to access an element outside of the array size will throw a ArrayIndexOutOfBoundsException
        ```
        int[] intArray = new int[] { 1, 2, 3, 4, 5}
        for(int i = 0; i <= 5; i++) {
            System.out.println(intArray[i]);
        } 
        
        // Output for the above will be:
        // 1
        // 2
        // 3
        // 4
        // 5
        // ArrayIndexOutOfBoundsException
        ```

    #
    #### ArrayList
    - An ArrayList is a resizable array. While it builds off an array, the syntax is different. 

    - ArrayList must be imported:
        ```
        import java.util.ArrayList;
        ```

    - Initializing an ArrayList
        ```
        ArrayList<String> cars = new ArrayList<String>();
        ```

    - Accessing an Item:
        ```
        cars.get(0); // Gets the first element.
        ```

    - Change an Item:
        ```
        cars.set(0, "Toyota");
        ```

    - Remove an Item:
        ```
        cars.remove(0);
        ```

    - Add an Item:
        ```
        cars.add("Ford");
        ```

    #
    #### Dictionary
    - Outdated
        - Dictionary does not implement the Map interface while HashMap does.
        - Dictionary uses enumeration (outdated/bad) while Map uses Iterator. 
            - You cannot make any modifications to the Collection while traversing the Collection using Enumeration. 
            - Iterator has a remove() method.

    #
    #### Hashmap
    - Data is stored in key value pairs. This class/data structure implements the Map interface but it is not part of the collection. 
    - Hashing techniques are used to store these key value pairs.
    - Unsynchronized
    - Allows one null key and any number of null values.

    - Creating a hashmap:
        ```
        HashMap<String, String> capitalCities = new HashMap<String, String>();
        ```
    
    - Adding to a hashmap:
        ```
        capitalCities.put("England", "London");
        capitalCities.put("Germany", "Berlin");
        capitalCities.put("Norway", "Oslo");
        capitalCities.put("USA", "Washington DC");
        capitalCities.put("NotYetCreatedCountry", null);
        ```
    
    - Accessing an item in a hashmap
        ```
        capitalCities.get("England");
        System.out.println(capitalCities.get("England"));
        ```
    
    - Remove an item in a hashmap
        ```
        capitalCities.remove("England");
        ```
    - Clear all the items in a hashmap
        ```
        capitalCities.clear();
        ```


    #
    #### HashTable
    - Synchronized (making it slower than non-synchronized data structures.)
    - Does not allow any null keys or values. 

#
#### OOP 
OOP - Object Oriented Programming is a programming concept that works on the principle that objects are the most important part of your program. It allows users create the objects that they want and then create methods to handle those objects. Manipulating these objects to get results is the goal of Object Oriented Programming.

Four core OOP concepts:
- Abstraction - Using simple things to represent complexity. Example: knowing how to turn a TV on but not knowing how a TV is able to turn on.
- Encapsulation - The practice of keeping fields within a class private then providing access via public methods.
- Inheritance - Lets classes share some attributes with existing classes without reinventing the wheel.
- Polymorphism - Allows the same method to do different things based on the class that called the method. The result of Inheritance.

    #
    #### Inheritance
    - Inheritance is one of the "big four" pillar of OOP (Object Oriented Programming). 
    - Inheritance allows one class to acquires the properties (methods and fields) of another class. 
    - Inheritance defines an "is-a" relationship. 
        - "Dog is an Animal" But not all animals are dogs. (Only one directional is-a relationship)
        - "Animal is the superclass of the Dog subclass"

    - The extends keyword is used to inherit the properties of the class listed after it.
        ```
            class Super {

            }

            class Sub extends Super {

            }
        ```
        
        - The class Sub is inheriting all the methods and fields of the Super class. 

    - Super Class
        - The class whose features are inherited is known as super class(or a base class or a parent class). The super class of every other class is the Object class.
    - Sub Class
        - The class that inherits the other class is known as sub class(or a derived class, extended class, or child class). The subclass can add its own fields and methods in addition to the superclass fields and methods.

    - The main reason to use Inheritance:
        - Reusability: Inheritance supports the concept of “reusability”, i.e. when we want to create a new class and there is already a class that includes some of the code that we want, we can derive our new class from the existing class. By doing this, we are reusing the fields and methods of the existing class.

    - Super keyword
        - Used to differentiate the members of the superclass from the members of the subclass
        - Used to invoke the superclass constructor from the subclass.
        ```
        super.variableName
        super.methodName()
        ```

    #
    #### Polymorphism
    - Polymorphism means "many forms" and it occurs when we have many classes that are related to each other by inheritance. 
    - While Inheritance allows the subclass to inherit attributes and methods, Polymorphism allows us to use those methods to perform different tasks. 

        ```
        class Animal {
            public void animalSound() {
                System.out.println("The animal makes a sound");
            }
        }

        class Pig extends Animal {
            @override
            public void animalSound() {
                System.out.println("The pig says: wee wee");
            }
        }

        class Dog extends Animal {
            @override
            public void animalSound() {
                System.out.println("The dog says: bow wow");
            }
        }

        class MyMainClass {
            public static void main(String[] args) {
                Animal myAnimal = new Animal();  // Create a Animal object
                Animal myPig = new Pig();  // Create a Pig object
                Animal myDog = new Dog();  // Create a Dog object

                myAnimal.animalSound(); // The animal makes a sound
                myPig.animalSound(); // The pig says: wee wee
                myDog.animalSound(); // The dog says: bow wow
            }
        }
        ```

        #
        #### Overriding
        - Overriding is a feature that allows a subclass or child class to provide a specific implementation of a method that is already provided by one of its super-classes or parent classes. 
        - Requires:
            - The use of the @Override annotation. 
            - The method name and parameters must match the parent's in order for the annotation to work. 
            - The overriding method must have same return type (or subtype)

        - Restrictions:
            - Final methods cannot be overridden. 
            - Static methods cannot be overridden. 
            - Private methods can not be overridden.

    #   
    #### Abstraction
    - In Object-oriented programming, abstraction is a process of hiding the implementation details from the user, only the functionality will be provided to the user. In other words, the user will have the information on what the object does instead of how it does it.

    - In Java, abstraction is achieved using Abstract classes and interfaces.

    - Using simple things to represent complexity. 
        - Example: knowing how to turn a TV on but not knowing how a TV is able to turn on. 
        - Example: a car is viewed as a car not as the individual components that make up the car.

    - Why should we use Abstract classes?
      - There is no requirement that an abstract class MUST be used.
      - Abstract classes allow developers to tell themselves and other developers that any class marked as abstract is NOT COMPLETE. 
        - This means that when the developer or anyone else uses the class they get a compiler warning that the class needs to have it's methods implemented.

    - Requirements:
        - For a class to be abstract, it must be declared with the abstract keyword 
            ```
            public abstract class Employee
            ```
        - For a method to be abstract, it must be declared with the abstract keyword
            ```
            public abstract double computePay();
            ```
            - Methods declared as abstract has a method signature but not method body. 
                - Methods must end with a semicolon rather than brackets. 
        - If a class contains at least one abstract method, the class must be declared as abstract.
        - If a class is declared abstract, then it cannot be instantiated. 
            - To use an abstract class you must inherit it from another class and provide implementation for any abstract methods contained within the abstract class.
            ```
            public abstract class Employee {
                private String name;
                private String address;
                private int number;
                
                public abstract double computePay();
                // Remainder of class definition
            }

            /* File name : Salary.java */
            public class Salary extends Employee {
                private double salary;   // Annual salary
                
                public double computePay() {
                    System.out.println("Computing salary pay for " + getName());
                    return salary/52;
                }
                // Remainder of class definition
            }
            ```

    #
    #### Encapsulation 
    - Encapsulation in Java is a mechanism of wrapping the data (variables) and code acting on the data (methods) together as a single unit.
    - In encapsulation, the variables of a class will be hidden from other classes, and can be accessed only through the methods of their current class. Therefore, it is also known as data hiding.

    - Benefits of Encapsulation:
        - The fields of a class can be made read-only or write-only.
        - A class can have total control over what is stored in its fields.

    - To achieve encapsulation in Java:
    - Declare the variables of a class as private.
    - Provide public setter and getter methods to modify and view the variables values.
        ```
        /* File name : EncapTest.java */
        public class EncapTest {
        private String name;
        private int Age;

        // Getter
        public int getAge() {
            return age;
        }

        // Setter
        public void setAge( int newAge) {
            age = newAge;
        }

        public String getName() {
            return name;
        }

        public void setName(String newName) {
        name = newName;
        }
        ```

        #
        #### Access Modifiers
        - The access modifiers in java specifies accessibility (scope) of a data member, method, constructor or class.

        - There are 4 types of java access modifiers:
            - private
            - default
            - protected
            - public

            <br>

            | Access Modifier | Access in Class | Access in Package | Access in Subclass | Global      |
            |-----------------|-----------------|-------------------|--------------------|-------------|
            | Public          | Allowed         | Allowed           | Allowed            | Allowed     |
            | Protected       | Allowed         | Allowed           | Allowed            | Not Allowed |
            | Default         | Allowed         | Allowed           | Not Allowed        | Not Allowed |
            | Private         | Allowed         | Not Allowed       | Not Allowed        | Not Allowed |

        -  Non-access modifiers:
            - static
            - abstract 
            - synchronized 
            - native
            - volatile
            - transient mark

        #
        #### Packages
        - A package in Java is used to group related classes. 
        - Think of it as a folder in a file directory. 
        - We use packages to avoid name conflicts, and to write a better maintainable code.

        - Packages are divided into two categories:
            - Built-in Packages (packages from the Java API)
            - User-defined Packages (create your own packages)

        - Importing a package:
            ```
            import package.name.Class; // Imports a single class.
            import package.name.*; // Imports the whole package.
            ```

#
#### Interface
- An interface is a completely "abstract class" that is used to group related methods with empty bodies.
- Another way to achieve abstraction in Java
- Interface methods are by default abstract and public
- Interface attributes are by default public, static and final.

- Use interfaces to:
    - Achieve total abstraction.
    - Achieve multiple inheritance
    - Achieve loose coupling.
```
interface Animal {
    int numberOfFeet = 0; // THIS VALUE IS PUBLIC STATIC AND FINAL. (Visable to the world, belongs to the interface/class, and cannot be changed.)

    public void animalSound(); // interface method (does not have a body)
    public void sleep(); // interface method (does not have a body)
}

// Pig "implements" the Animal interface
class Pig implements Animal {
  public void animalSound() {
    // The body of animalSound() is provided here
    System.out.println("The pig says: wee wee");
  }
  public void sleep() {
    // The body of sleep() is provided here
    System.out.println("Zzz");
  }
}
```

#
#### Interface vs Abstract Class
- Interface Benefits:
    - Multiple interfaces can be implemented. 
    - Loose coupling. 

- Interface Disadvantages:
    - All methods are implicitly abstract (cannot provide implementation for methods)
    - Variables are always public, static, and final. 
    - An interface can extend another Java interface only.

- Abstract Benefits:
    - Variables may have non-final variables.
    - An abstract class can extend another Java class and implement multiple Java interfaces.

- Abstract Disadvantages:
    - Must be inherited (only one class may be inherited at a time)
    - Variables may be private, protected, non-static, and non-final

- Interface and Abstract Similarities:
    - Cannot be instantiated. 



#
#### Exceptions
- An Exception is a problem that arises during the execution of a program. 
- When an Exception occurs the normal flow of the program is disrupted and the program/Application terminates abnormally, which is not recommended, therefore, these exceptions are to be handled.
- Examples: NullPointerException, ArrayIndexOutOfBoundsException, IOException

    #
    #### Checked
    - Checked exceptions − A checked exception is an exception that is checked (notified) by the compiler at compilation-time, these are also called as compile time exceptions. These exceptions cannot simply be ignored, the programmer should take care of (handle) these exceptions.

    - Example: FileReader class throws a FileNotFoundException.

    #
    #### Unchecked
    - Unchecked exceptions − An unchecked exception is an exception that occurs at the time of execution. 
    - These are also called as Runtime Exceptions. These include programming bugs, such as logic errors or improper use of an API. Runtime exceptions are ignored at the time of compilation.

    - Example: For example, if you have declared an array of size 5 in your program, and trying to call the 6th element of the array then an ArrayIndexOutOfBoundsException occurs.

    #
    #### Catching Exceptions
    - A method catches an exception using a combination of the try and catch keywords. 
    - A try/catch block is placed around the code that might generate an exception. 
    - Code within a try/catch block is referred to as protected code, and the syntax for using try/catch looks like the following:
    ```
    try {
        // Protected code.
    } catch (ExceptionName e1) {
        // Catch block must accompany a try statement.
        printStackTrace();
    } catch (ExceptionName e2) {
        // Catches a different exception.
        printStackTrace();
    } finally {
        // The finally block always executes but is not required.
    }
    ```

    #
    #### User-defined Exceptions
    - You can create your own exceptions in Java. Keep the following points in mind when writing your own exception classes:
        - All exceptions must be a child of Throwable.
        - If you want to write a checked exception that is automatically enforced by the Handle or Declare Rule, you need to extend the Exception class.
        - If you want to write a runtime exception, you need to extend the RuntimeException class.

        ```
        // File Name InsufficientFundsException.java
        import java.io.*;

        public class InsufficientFundsException extends Exception {
            private double amount;
            
            public InsufficientFundsException(double amount) {
                this.amount = amount;
            }
            
            public double getAmount() {
                return amount;
            }
        }

        // File Name CheckingAccount.java
        import java.io.*;

        public class CheckingAccount {

            public void withdraw(double amount) throws InsufficientFundsException {
                if(amount <= balance) {
                    balance -= amount;
                }else {
                    double needs = amount - balance;
                    throw new InsufficientFundsException(needs);
                }
            }    
        }
        ```
    #
    #### Throw
    - Throw keyword is used in the method body to throw an exception, while throws is used in method signature to declare the exceptions that can occur in the statements present in the method.

    ```
    void checkAge(int age){  
        if(age<18)  
            throw new ArithmeticException("Not Eligible for voting");  
        else  
            System.out.println("Eligible for voting");  
    } 
    ```

    #
    #### Throws
    - If a method does not handle a checked exception, the method must declare it using the ```throws``` keyword. 
    - The throws keyword appears at the end of a method's signature.
    - ```throws``` is used to postpone the handling of a checked exception and ```throw``` is used to invoke an exception explicitly.

    - Example: 
    ```
    import java.io.*;
    public class className {

    public void deposit(double amount) throws RemoteException {
        // Method implementation
        throw new RemoteException();
    }
        // Remainder of class definition
    }

    public void withdraw(double amount) throws RemoteException, InsufficientFundsException {
        // Method implementation
        throw new RemoteException();
    }
        // Remainder of class definition
    }
    ```

#
#### Final Variables/Methods/Classes
- When final keyword is used with a variable of primitive data types (int, float, .. etc), value of the variable cannot be changed.
    ```
    public class Test { 
        public static void main(String args[]) { 
            final int i = 10; 
            i = 30; // Error because i is final. 
        } 
    } 
    ```

- When final is used with non-primitive variables (Note that non-primitive variables are always references to objects in Java), the members of the referred object can be changed. final for non-primitive variables just mean that they cannot be changed to refer to any other object. 
    ```
    class Test1 { 
        int i = 10; 
    } 
    
    public class Test2 { 
        public static void main(String args[]) { 
        final Test1 t1 = new Test1(); 
        t1.i = 30;  // Works 
        } 
    } 
    ```

- Final methods should be used when you want to make sure functionality will not change.
    - Methods called from constructors should generally be declared final. If a constructor calls a non-final method, a subclass may redefine that method with surprising or undesirable results.

- Final methods cannot be overridden by subclasses. 
    - Since private methods are inaccessible, they are implicitly final in Java. So adding final specifier to a private method doesn’t add any value.
    
    ```
    public class Counter {
        private int counter = 0;

        public final int count() {
            return counter++;
        }

        public final int reset() {
            return (counter = 0);
        }
    }
    ```

- A class that is declared final cannot be subclassed (cannot be extended). 
    - This is useful when you want to create an immutable class (such as the String class)
        - It may be desired that a class should not be extendable by other classes to prevent exploitation.
    
    ```
    public final class A {
        // code
    }

    class B extends A { // This will result in a compilation error. }
    ```

    #
    #### Immutability 
    - An immutable object is an object whose internal state remains constant after it has been entirely created.
        - This means that the public API of an immutable object guarantees us that it will behave in the same way during its whole lifetime.
        - The API gives us read-only methods, it should never include methods that change the internal state of the object.

    - Benefits:
        - Since the internal state of an immutable object remains constant in time, we can share it safely among multiple threads.

        - We can also use it freely, and none of the objects referencing it will notice any difference, we can say that immutable objects are side-effects free.

        ```
        class Money {
            private final double amount;
            private final Currency currency;
        
            public Money(double amount, Currency currency) {
                this.amount = amount;
                this.currency = currency;
            }

            public Currency getCurrency() {
                return currency;
            }
        
            public double getAmount() {
                return amount;
            }
        }
        ```

#
#### Static Variables/Methods/Block
- Uses the ```static``` keyword.
- Static methods are the methods in Java that can be called without creating an object of class. 
- They are referenced by the class name itself or reference to the Object of that class.
- The static variable gets memory only once in the class area at the time of class loading. It makes your program memory efficient.
- They are designed with aim to be shared among all Objects created from the same class.
- Static methods cannot be overridden. 

    - Static Variable
        - Creating
        ```
        public class StaticExample {
            static int i = 1;
        }
        
        ```
        
        - Calling
        ```
        public class AnotherClass {
            int f = StaticExample.i; // f now equals 1.
        } 
        ```

    - Static Method
        - Creating
        ```
        public class StaticExample {
            public static add(int first, int second) {
                // some logic here.
            } 
        }
        ```

        - Calling
        ```
        public class AnotherClass {
            int f = StaticExample.add(5, 2); // f now equals 7.
        } 
        ```

    - Static Block 
        - This code inside static block is executed only once: the first time you make an object of that class or the first time you access a static member of that class (even if you never make an object of that class).
        ```
            class StaticExample {
                static int i;
                int j;

                static {
                    i = 10;
                    System.out.println("static block called.");
                }
            }
        ```

#
#### Overloading
- Method Overloading is a feature that allows a class to have more than one method having the same name, if their argument lists are different.

```
add(int, int)
add(int, int, int)
add(char, int, int) 
add(int, int, char) // Different order of parameters is ok too
```

#
#### Constructor
- A constructor is a special method that is used to initialize objects. 
- The constructor is called when an object of a class is created. It can be used to set initial values for object attributes:
- Types of Constructors:
    - Default: No parameters in the constructor method.
    ```
    public class MyClass {
        int x;

        public MyClass() {
            x = 0;
        }
    }
    ```
    - Parameterized: Parameters in the constructor method.
    ```
    public class MyClass {
        int x;

        public MyClass(int y) {
            x = y;
        }
    }
    ```
    #
    #### Ways of Creating an Object
    ```
        // Constructor called.
        1. MyObject object = new MyObject();
        // Requires knowledge of a class name and if that class has a public constructor. - Constructor Called.
        1. MyObject object = (MyObject) Class.forName("package.name.MyObject").newInstance();
        // Object Cloning - No Constructor Called.
        1. MyObject anotherObject = myObject();
            MyObject object = (MyObject) anotherObject.clone();
        // Object Deserialization - No Constructor Called.
        1. ObjectInputStream in = new ObjectInputStream(new FileInputStream("data.obj"));
            Employee emp5 = (Employee) in.readObject();
    ```

#
#### Class relations
- Classes can be related through:
    - Inheritance
    - Composition
    - Aggregation
    - Association

    #
    #### Composition
    - Composition is a restricted form of Aggregation in which two entities are highly dependent on each other.
        - It represents part-of relationship.
        - In composition, both the entities are dependent on each other.
        - When there is a composition between two entities, the composed object cannot exist without the other entity.

    #
    #### Aggregation 
    - It is a special form of Association where:
        - It represents Has-A relationship.
        - It is a unidirectional association i.e. a one way relationship. For example, department can have students but vice versa is not possible and thus unidirectional in nature.
        - In Aggregation, both the entries can survive individually which means ending one entity will not effect the other entity

    #
    #### Association 
    - Defines a one-to-many relationship. 
    ```
    // Java program to illustrate the  
    // concept of Association 
    import java.io.*; 
    
    // class bank 
    class Bank  
    { 
        private String name; 
        
        // bank name 
        Bank(String name) 
        { 
            this.name = name; 
        } 
        
        public String getBankName() 
        { 
            return this.name; 
        } 
    }  
    
    // employee class  
    class Employee 
    { 
        private String name; 
        
        // employee name  
        Employee(String name)  
        { 
            this.name = name; 
        } 
        
        public String getEmployeeName() 
        { 
            return this.name; 
        }  
    } 
    
    // Association between both the  
    // classes in main method 
    class Association  
    { 
        public static void main (String[] args)  
        { 
            Bank bank = new Bank("Axis"); 
            Employee emp = new Employee("Neha"); 
            
            System.out.println(emp.getEmployeeName() +  
                " is employee of " + bank.getBankName()); 
        } 
    } 

    // Output: Neha is employee of Axis
    ```

#
#### JVM/JRE/JDK
JVM - Java Virtual Machine is responsible for running Byte code (.java files (human-readable) are compiled in order to create the .class files (JVM readable) that is then run by the JVM.) and provides core java functions such as memory management and garbage collection. Byte code is an intermediary language that gives Java it's write once run anywhere ability. 

JRE - Java Runtime Environment provides the libraries, the Java Virtual Machine, and other components to run applets and applications written in the Java programming language.

JDK - Java Development Kit is a superset of the JRE, and contains everything that is in the JRE, plus tools such as the compilers and debuggers necessary for developing applets and applications.

#
#### IDE
An integrated development environment (IDE) is an application that makes the application development process easier and faster.

Some tools offered: 
- Code editor: enhances and simplifies the writing and editing of code.
- Compiler: Converts the human readable language to machine language.
- Debugger: This tool is used during testing to help debug applications.
- Build Automation Tools: Automates common developer tasks.

Some examples of IDEs:
- IntelliJ IDEA
- Eclipse
- Visual Studio Code