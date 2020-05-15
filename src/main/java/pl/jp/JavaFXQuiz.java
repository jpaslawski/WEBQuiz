package pl.jp;

import javafx.application.Application;
import javafx.geometry.Insets;
import javafx.geometry.Pos;
import javafx.scene.Scene;
import javafx.scene.control.*;
import javafx.scene.control.Button;
import javafx.scene.control.Label;
import javafx.scene.control.Menu;
import javafx.scene.control.MenuBar;
import javafx.scene.control.MenuItem;
import javafx.scene.control.ScrollPane;
import javafx.scene.control.TextArea;
import javafx.scene.control.TextField;
import javafx.scene.image.Image;
import javafx.scene.image.ImageView;
import javafx.scene.layout.AnchorPane;
import javafx.scene.layout.BorderPane;
import javafx.scene.layout.VBox;
import javafx.scene.text.Font;
import javafx.stage.FileChooser;
import javafx.stage.Stage;
import pl.jp.models.*;

import java.io.*;
import java.nio.file.Files;
import java.nio.file.StandardCopyOption;
import java.util.*;
import java.util.List;
import java.util.stream.IntStream;

public class JavaFXQuiz extends Application {

    /** Menu Bar and items for admin **/
    private Menu quiz;
    private MenuBar menuBar;

    /** Menu Bar and items for student **/
    private Menu studentMenuQuiz;
    private MenuBar studentMenuBar;


    /** Sign In Layout objects **/
    private TextField emailField = new TextField();
    private PasswordField passwordField = new PasswordField();
    private Button singInBtn = new Button("Sign In");
    private Hyperlink linkToSignUp = new Hyperlink("Create a new account");
    private VBox signInBox;

    /** Sign Up Layout objects **/
    private TextField signUpEmailField = new TextField(),
            signUpFirstNameField = new TextField(),
            signUpLastNameField = new TextField();
    private PasswordField signUpPasswordField = new PasswordField(),
            signUpPasswordConfirmField = new PasswordField();
    private Button signUpBtn = new Button("Sign Up");
    private Hyperlink linkToSignIn = new Hyperlink("Already have an account? Sign In");
    private VBox signUpBox;

    /** Variables used in the quiz (load and check data) **/
    private List<Question> questions;
    private List<SingleResult> singleResultList;
    private QuizResult quizResult;
    private int currentQuestion = 0, questionAmount, points=0;
    private String[] answers;
    private int[] correctAnswers;
    private String questionContent, attachedFile;

    /** Quiz end Layout objects **/
    private Label endQuizLabel = new Label("This quiz is over!"),
            resultLabel = new Label("Your result in this quiz is: ");
    private Button returnHomeBtn = new Button("Back to Quiz list");
    private VBox endQuizBox;

    /** Quiz Layout objects **/
    private Label questionNumber = new Label(""),
            questionLabel = new Label("");
    private TextArea codeArea = new TextArea();
    private ImageView imageView = new ImageView();
    private CheckBox answer1 = new CheckBox(""),
            answer2 = new CheckBox(""),
            answer3 = new CheckBox(""),
            answer4 = new CheckBox("");
    private Button next = new Button("Next Question");
    private VBox quizBox;

    /** Show all quizzes layout **/
    private Label showAllLabel = new Label("The list of quizzes:");
    private VBox allQuizzesBox;

    /** New Quiz Form Layout objects **/
    private Label quizName = new Label("Quiz Name"),
            quizInfo = new Label("Additional Info"),
            errorLabel = new Label("");
    private TextField nameField = new TextField(), infoField = new TextField();
    private Button addQuiz = new Button("Add Quiz");
    private VBox newQuizBox;

    /** New Question Form Layout objects **/
    private TextField questionField = new TextField(),
            answer1Field = new TextField(),
            answer2Field = new TextField(),
            answer3Field = new TextField(),
            answer4Field = new TextField();
    private CheckBox answer1Check = new CheckBox(""),
            answer2Check = new CheckBox(""),
            answer3Check = new CheckBox(""),
            answer4Check = new CheckBox("");
    private Label chosenFile = new Label("File name: ");
    private boolean fileValid = false;
    private File file;
    private Button addQuestionBtn = new Button("Continue"), chooseFile = new Button("Choose file");
    private VBox questionFormBox;

    /** Add Question to Quiz Layout objects **/
    private Label questionToQuizLabel= new Label("Choose the quizzes in which you want to insert the question: ");
    private Button addQuestionToQuizBtn = new Button("Add Question To Quiz");
    private VBox questionToQuizBox;

    /** User results Layout objects **/
    private Label userResultsLabel = new Label("The list of results of quizzes you have taken in the past: ");
    private VBox userResultsBox;

    /** Single Quiz result Layout objects **/
    private Label percentageLabel;
    private VBox singleResultBox;

    private ReadJsonFile reader = new ReadJsonFile();
    private BorderPane root;
    private Label footer;

    private User loggedInUser;

    @Override
    public void start(Stage primaryStage) {
        root = new BorderPane();

        menuBar = new MenuBar();
        studentMenuBar = new MenuBar();

        quiz = new Menu("Quiz");
        studentMenuQuiz = new Menu("Quiz");

        MenuItem showQuiz = new MenuItem("Show all");
        MenuItem addQuiz = new MenuItem("Add new Quiz");
        MenuItem addQuestion = new MenuItem("Add new Question");

        quiz.getItems().addAll(showQuiz, addQuiz, addQuestion);

        Menu profile = new Menu("Profile");
        MenuItem userResults = new MenuItem("Your results");
        MenuItem logout = new MenuItem("Logout");

        profile.getItems().addAll(userResults, logout);

        menuBar.getMenus().addAll(quiz, profile);
        studentMenuBar.getMenus().addAll(studentMenuQuiz, profile);

        showQuiz.setOnAction(e -> {
            loadAllQuizzesScene();
            root.setCenter(allQuizzesBox);
        });

        addQuiz.setOnAction(e -> {
            loadNewQuizFormScene();
            root.setCenter(newQuizBox);
        });

        addQuestion.setOnAction(e -> {
            loadNewQuestionFormScene();
            root.setCenter(questionFormBox);
        });

        userResults.setOnAction(e -> {
            loadResultsScene();
            root.setCenter(userResultsBox);
        });

        logout.setOnAction(e -> {
            signIn();
            root.setTop(null);
            root.setCenter(signInBox);
        });

        footer = new Label("JavaFX Quiz Application, © Copyright 2020 Jerzy Pasławski");
        footer.setMaxWidth(Double.MAX_VALUE);
        AnchorPane.setLeftAnchor(footer, 0.0);
        AnchorPane.setRightAnchor(footer, 0.0);
        footer.setAlignment(Pos.CENTER);
        root.setBottom(footer);

        errorLabel.setStyle("-fx-text-fill: red");

        signIn();
        root.setCenter(signInBox);

        Scene scene = new Scene(root, 500, 500);
        primaryStage.setTitle("JavaPRO - Quiz");
        primaryStage.setScene(scene);
        primaryStage.setResizable(false);
        primaryStage.show();
    }

    public static void main(String[] args) {
        launch(args);
    }

    private void chooseQuiz(String quizName) {
        questions = reader.getQuestions(quizName);
        if(questions == null) {
            new AlertBox().display("File not found", "Unfortunately this quiz has no questions yet! Try again later...");
        } else {
            currentQuestion = 0;
            questionAmount = questions.size();
            menuBar.setDisable(true);
            studentMenuBar.setDisable(true);
            loadQuizScene();
            root.setCenter(quizBox);
        }
    }

    public void signIn() {

        errorLabel.setText("");
        signInBox = new SignInLayout().loadSignInLayout(emailField, passwordField, singInBtn, linkToSignUp, errorLabel);
        singInBtn.setOnAction(e -> {
            String email = emailField.getText();
            String password = passwordField.getText();

            if(email == null || email.trim().isEmpty()) {
                errorLabel.setText("The email field is empty!");
            } else if(password == null || password.trim().isEmpty()) {
                errorLabel.setText("The password field is empty!");
            } else {
                User user = new ReadJsonFile().getUser(email);
                if (user == null) {
                    errorLabel.setText("A user with the given email doesn't exist!");
                } else if (password.equals(user.getPassword())) {
                    if(user.getRole().equals("admin")) {
                        root.setTop(menuBar);
                    } else {
                        root.setTop(studentMenuBar);
                    }

                    emailField.clear();
                    passwordField.clear();

                    loggedInUser = user;

                    loadAllQuizzesScene();
                    root.setCenter(allQuizzesBox);
                } else {
                    errorLabel.setText("The provided password is wrong!");
                }
            }
        });

        linkToSignUp.setOnAction(e -> {
            signUp();
            root.setCenter(signUpBox);
        });
    }

    public void signUp() {

        errorLabel.setText("");
        signUpBox = new SignUpLayout()
                .loadSignUpLayout(signUpFirstNameField, signUpLastNameField, signUpEmailField, signUpPasswordField,
                        signUpPasswordConfirmField, signUpBtn, linkToSignIn, errorLabel);

        signUpBtn.setOnAction(e -> {
            String firstName = signUpFirstNameField.getText();
            String lastName = signUpLastNameField.getText();
            String email = signUpEmailField.getText();
            String password = signUpPasswordField.getText();
            String confirmPassword = signUpPasswordConfirmField.getText();

            if(firstName == null || firstName.trim().isEmpty()) {
                errorLabel.setText("You have to provide your first name!");
            } else if(lastName == null || lastName.trim().isEmpty()) {
                errorLabel.setText("You have to provide your last name!");
            } else if(email == null || email.trim().isEmpty()) {
                errorLabel.setText("The email field cannot be empty!");
            } else if(password == null || password.trim().isEmpty()) {
                errorLabel.setText("The password field cannot be empty!");
            } else {
                List<User> userList = new ReadJsonFile().getUsers();
                boolean found = false;

                for(User user : userList) {
                    if(email.equals(user.getEmail())) {
                        found = true;
                        break;
                    }
                }

                if (found) {
                    errorLabel.setText("An account with this email already exists!");
                } else {
                    if(!password.equals(confirmPassword)) {
                        errorLabel.setText("Passwords don't match!");
                    } else {
                        User user = new User(firstName, lastName, email, password, "student");
                        userList.add(user);
                        reader.addNewUser(userList);

                        signUpFirstNameField.clear();
                        signUpLastNameField.clear();
                        signUpEmailField.clear();
                        signUpPasswordField.clear();
                        signUpPasswordConfirmField.clear();

                        signIn();
                        root.setCenter(signInBox);
                    }
                }
            }
        });

        linkToSignIn.setOnAction(e -> {
            signIn();
            root.setCenter(signInBox);
        });
    }

    public void loadQuizScene() {

        quizBox = new VBox();
        quizBox.setPadding(new Insets(20, 20, 20, 20));
        quizBox.setSpacing(10);
        next.setDisable(true);
        loadQuestion();

        next.setOnAction(e -> {
            boolean selectedAnswers[] = {
                    answer1.isSelected(),
                    answer2.isSelected(),
                    answer3.isSelected(),
                    answer4.isSelected()
            };
            ArrayList<Integer> selAnswersToInt = new ArrayList<Integer>();
            for(int i = 0; i < 4; i++) {
                if(selectedAnswers[i]) {
                    selAnswersToInt.add(i+1);
                }
            }
            int[] finalAnswers = selAnswersToInt.stream().mapToInt(i -> i).toArray();
            SingleResult singleResult = new SingleResult(questionContent, new String[]{answer1.getText(),
                    answer2.getText(), answer3.getText(), answer4.getText()}, correctAnswers, finalAnswers);
            if (singleResultList == null) {
                singleResultList = new LinkedList<SingleResult>();
            }
            singleResultList.add(singleResult);
            currentQuestion++;
            loadQuestion();
        });
    }

    public void loadAllQuizzesScene() {
        allQuizzesBox = new VBox();
        allQuizzesBox.setPadding(new Insets(20, 20, 20, 20));
        allQuizzesBox.setSpacing(10);

        allQuizzesBox.getChildren().add(showAllLabel);

        List<Quiz> quizzes = reader.getQuizzes();
        for(Quiz quiz:quizzes) {
                Button btn = new Button(quiz.getName());
                btn.setOnAction(e -> {
                    chooseQuiz(quiz.getFileName());
                });
                allQuizzesBox.getChildren().add(btn);
        }
    }

    public void loadNewQuizFormScene() {
        errorLabel.setText("");
        newQuizBox = new QuizForm().loadQuizFormLayout(nameField, infoField, errorLabel, addQuiz);

        addQuiz.setOnAction(e -> {
            String qName = nameField.getText();
            String qInfo = infoField.getText();
            System.out.println(qName + "  " + qInfo);
            if(qName == null || qName.trim().isEmpty()) {
                errorLabel.setText("You have to provide a quiz name!");
            } else {
                List<Quiz> quizzes = reader.getQuizzes();
                boolean found = false;

                for(Quiz quiz : quizzes) {
                   if(qName.equals(quiz.getName())) {
                       found = true;
                       break;
                   }
                }
                if (found) {
                    errorLabel.setText("A quiz with this name already exists!");
                } else {
                    Quiz newQuiz = new Quiz(qName, qInfo, "quiz" + (quizzes.size() + 1) + ".json", false);
                    quizzes.add(newQuiz);
                    reader.addNewQuiz(quizzes);

                    loadAllQuizzesScene();
                    root.setCenter(allQuizzesBox);
                }
            }
        });
    }

    public void loadNewQuestionFormScene() {
        questionField.clear();
        answer1Field.clear();
        answer2Field.clear();
        answer3Field.clear();
        answer4Field.clear();
        answer1Check.setSelected(false);
        answer2Check.setSelected(false);
        answer3Check.setSelected(false);
        answer4Check.setSelected(false);

        questionFormBox = new QuestionForm()
                .loadQuizFormLayout(questionField, answer1Check, answer1Field, answer2Check, answer2Field, answer3Check,
                        answer3Field, answer4Check, answer4Field, chosenFile, chooseFile, errorLabel, addQuestionBtn);

        chooseFile.setOnAction(e -> {
            FileChooser fileChooser = new FileChooser();
            FileChooser.ExtensionFilter jpg = new FileChooser.ExtensionFilter("JPG files","*.jpg");
            FileChooser.ExtensionFilter txt = new FileChooser.ExtensionFilter("TXT files","*.txt");
            fileChooser.getExtensionFilters().addAll(txt, jpg);
            file = fileChooser.showOpenDialog(null);
            if (file != null) {
                chosenFile.setText("File name: " + file.getName());
                fileValid = true;
            } else {
                chosenFile.setText("File not valid!");
                fileValid = false;
            }
        });

        addQuestionBtn.setOnAction(e -> {
            String questionContent = questionField.getText();
            String answer1 = answer1Field.getText();
            String answer2 = answer2Field.getText();
            String answer3 = answer3Field.getText();
            String answer4 = answer4Field.getText();

            boolean[] checkedBoxes = {
                    answer1Check.isSelected(),
                    answer2Check.isSelected(),
                    answer3Check.isSelected(),
                    answer4Check.isSelected()
            };

            if(questionContent == null || questionContent.trim().isEmpty()) {
                errorLabel.setText("The question content field cannot be empty!");
            } else if (answer1 == null || answer1.trim().isEmpty()) {
                errorLabel.setText("The first answer field is empty!");
            } else if (answer2 == null || answer2.trim().isEmpty()) {
                errorLabel.setText("The second answer field is empty!");
            } else if (answer3 == null || answer3.trim().isEmpty()) {
                errorLabel.setText("The third answer field is empty!");
            } else if (answer4 == null || answer4.trim().isEmpty()) {
                errorLabel.setText("The fourth answer field is empty!");
            } else if (!IntStream.range(0, checkedBoxes.length).anyMatch(i -> checkedBoxes[i])) {
                errorLabel.setText("You have to check at least one correct answer!");
            } else {
                Question newQuestion = new Question();
                newQuestion.setQuestion(questionContent);
                newQuestion.setAnswers(new String[]{answer1, answer2, answer3, answer4});

                ArrayList<Integer> correctAnswers = new ArrayList<>();
                int j = 0;
                for(int i=1; i<5; i++) {
                    if(checkedBoxes[i-1]) {
                        correctAnswers.add(i);
                        j++;
                    }
                }

                int[] finalArray = correctAnswers.stream().mapToInt(i -> i).toArray();
                newQuestion.setCorrectAnswers(finalArray);

                if (fileValid) {
                    try {
                        Files.copy(file.toPath(), new File(
                                new File("").getAbsolutePath() + "\\" + file.getName()).toPath(),
                                StandardCopyOption.REPLACE_EXISTING);
                        newQuestion.setAttachedFile(file.getName());
                    } catch (IOException ex) {
                        ex.printStackTrace();
                    }
                }

                loadQuestionToQuizScene(newQuestion);
                root.setCenter(questionToQuizBox);
            }
        });
    }

    public void loadQuestionToQuizScene(Question question) {
        errorLabel.setText("");
        questionToQuizBox = new VBox();
        questionToQuizBox.setPadding(new Insets(20, 20, 20, 20));
        questionToQuizBox.setSpacing(10);
        questionToQuizBox.getChildren().add(questionToQuizLabel);

        List<Quiz> quizzes = new ReadJsonFile().getQuizzes();
        List<CheckBox> checkboxes = new ArrayList<>();

        for (Quiz quiz : quizzes) {
            CheckBox quizCheckBox = new CheckBox(quiz.getName());
            checkboxes.add(quizCheckBox);
            questionToQuizBox.getChildren().add(quizCheckBox);
        }

        questionToQuizBox.getChildren().addAll(errorLabel, addQuestionToQuizBtn);
        addQuestionToQuizBtn.setOnAction(e -> {
            ArrayList<Integer> selectedQuizzes = new ArrayList<>();
            int i = 0;
            for (CheckBox checkBox:checkboxes) {
                if (checkBox.isSelected()) {
                    selectedQuizzes.add(i);
                }
                i++;
            }
            if (selectedQuizzes.isEmpty()) {
                errorLabel.setText("You have to choose at least one quiz!");
            } else {
                System.out.println(Arrays.toString(selectedQuizzes.toArray()));
                System.out.println(Arrays.toString(quizzes.toArray()));
                for (Integer quizNumber : selectedQuizzes) {
                    String quizFileName = quizzes.get(quizNumber).getFileName();
                    List<Question> questions = new ReadJsonFile().getQuestions(quizFileName);

                    if (questions == null) {
                        //File file = new File(ABSOLUTE_PATH + "\\src\\main\\resources\\", quizFileName);
                        File file = new File(quizFileName);
                        try {
                            file.createNewFile();
                        } catch (IOException ex) {
                            ex.printStackTrace();
                        }
                        try {
                            FileOutputStream oFile = new FileOutputStream(file, false);
                        } catch (FileNotFoundException ex) {
                            ex.printStackTrace();
                        }

                        List<Question> newList = new LinkedList<Question>();
                        newList.add(question);
                        new ReadJsonFile().addNewQuestion(newList, quizFileName);
                    } else {
                        questions.add(question);
                        new ReadJsonFile().addNewQuestion(questions, quizFileName);
                    }
                }
                loadAllQuizzesScene();
                root.setCenter(allQuizzesBox);
            }
        });
    }

    public void loadQuestion() {
        if(currentQuestion < questionAmount) {
            quizBox.getChildren().removeAll(questionNumber, questionLabel, codeArea, imageView, answer1, answer2, answer3, answer4, next);
            Question question = questions.get(currentQuestion);

            questionContent = question.getQuestion();
            answers = question.getAnswers();
            correctAnswers = question.getCorrectAnswers();
            attachedFile = question.getAttachedFile();

            questionNumber.setText("Question number: " + (currentQuestion + 1) + " / " + questionAmount);
            questionNumber.setStyle("-fx-font-weight: bold");
            questionNumber.setMaxWidth(Double.MAX_VALUE);
            AnchorPane.setLeftAnchor(questionNumber, 0.0);
            AnchorPane.setRightAnchor(questionNumber, 0.0);
            questionNumber.setAlignment(Pos.CENTER);

            questionLabel.setText(questionContent);

            answer1.setText(answers[0]);
            answer2.setText(answers[1]);
            answer3.setText(answers[2]);
            answer4.setText(answers[3]);

            next.setDisable(true);

            answer1.setOnAction(e -> manageButtonNext());
            answer2.setOnAction(e -> manageButtonNext());
            answer3.setOnAction(e -> manageButtonNext());
            answer4.setOnAction(e -> manageButtonNext());

            answer1.setSelected(false);
            answer2.setSelected(false);
            answer3.setSelected(false);
            answer4.setSelected(false);


            if (question.getAttachedFile() != null) {
                if (attachedFile.contains(".txt")) {
                    codeArea.setText("");
                    codeArea.setFont(Font.font("Consolas", 12));
                    codeArea.setEditable(false);
                    codeArea.setPrefSize(Double.MAX_VALUE, 100);
                    try {
                        BufferedReader reader = new BufferedReader(new FileReader(attachedFile));
                        String line = reader.readLine();
                        String text = line + System.lineSeparator();
                        while (line != null) {
                            line = reader.readLine();
                            if (line != null) {
                                text += line + System.lineSeparator();
                            }
                        }
                        codeArea.setText(text);
                        quizBox.getChildren().addAll(questionNumber, questionLabel, codeArea, answer1, answer2, answer3, answer4, next);
                    } catch (IOException e) {
                        e.printStackTrace();
                    }
                } else if (attachedFile.contains(".jpg")) {
                    imageView.setImage(new Image(new File(attachedFile).toURI().toString()));
                    imageView.setFitHeight(200);
                    imageView.setFitWidth(450);
                    quizBox.getChildren().addAll(questionNumber, questionLabel, imageView, answer1, answer2, answer3, answer4, next);
                }
            } else {
                quizBox.getChildren().addAll(questionNumber, questionLabel, answer1, answer2, answer3, answer4, next);
            }
        } else {
            endQuiz();
        }
    }

    public void manageButtonNext() {
        if(answer1.isSelected() || answer2.isSelected() || answer3.isSelected() || answer4.isSelected()) {
            next.setDisable(false);
        } else {
            next.setDisable(true);
        }
    }

    public void endQuiz() {
        calculateQuizResult();

        endQuizBox = new VBox();
        endQuizBox.setPadding(new Insets(20, 20, 20, 20));
        endQuizBox.setSpacing(10);

        endQuizLabel.setMaxWidth(Double.MAX_VALUE);
        endQuizLabel.setStyle("-fx-font-size: 20px;-fx-font-weight: bold;");
        AnchorPane.setLeftAnchor(endQuizLabel, 0.0);
        AnchorPane.setRightAnchor(endQuizLabel, 0.0);
        endQuizLabel.setAlignment(Pos.CENTER);

        resultLabel = new Label("Your result: " + quizResult.getPercentage());
        ScrollPane scrollPane = scrollPaneSetup(quizResult.getResultList());

        endQuizBox.getChildren().addAll(endQuizLabel, resultLabel, scrollPane, returnHomeBtn);
        root.setCenter(endQuizBox);

        new ReadJsonFile().saveResults(quizResult, loggedInUser.getEmail());

        returnHomeBtn.setOnAction(e -> {
            singleResultList = null;
            quizResult = null;
            menuBar.setDisable(false);
            studentMenuBar.setDisable(false);
            loadAllQuizzesScene();
            root.setCenter(allQuizzesBox);
        });
    }

    public void calculateQuizResult() {
        int points = 0;
        int sumOfPoints = singleResultList.size();
        for(SingleResult singleResult: singleResultList) {
            if (Arrays.equals(singleResult.getCorrectAnswers(), singleResult.getUserAnswers())) {
                points++;
            }
        }
        float percentage = points*100/sumOfPoints;

        quizResult = new QuizResult(loggedInUser, singleResultList, percentage);
    }

    public ScrollPane scrollPaneSetup(List<SingleResult> results) {
        ScrollPane scrollPane = new ScrollPane();
        scrollPane.setPrefSize(300, 300);
        scrollPane.setPadding(new Insets(20, 20, 20, 20));

        VBox scrollBox = new VBox();
        scrollBox.setSpacing(5);

        for(SingleResult singleResult : results) {
            List<CheckBox> checkboxes = new ArrayList<>();
            Label questionL = new Label(singleResult.getQuestion());
            questionL.setStyle("-fx-font-weight: bold");

            scrollBox.getChildren().add(questionL);

            for(int i = 0; i < 4; i++) {
                CheckBox checkBox = new CheckBox(singleResult.getAnswers()[i]);
                checkBox.setDisable(true);
                checkboxes.add(checkBox);
                scrollBox.getChildren().add(checkBox);
            }

            for (int userAnswer : singleResult.getUserAnswers()) {
                checkboxes.get(userAnswer-1).setSelected(true);
            }

            for (int correctAnswer : singleResult.getCorrectAnswers()) {
                checkboxes.get(correctAnswer - 1).setStyle("-fx-text-fill: green");
            }
        }

        scrollPane.setContent(scrollBox);

        return scrollPane;
    }

    public void loadResultsScene() {
        userResultsBox = new VBox();
        userResultsBox.setPadding(new Insets(20, 20, 20, 20));
        userResultsBox.setSpacing(10);
        userResultsBox.getChildren().add(userResultsLabel);

        List<QuizResult> quizResults = new ReadJsonFile().getUserResults(loggedInUser.getEmail());
        int i = 1;
        for(QuizResult quizResult : quizResults) {
            Button resultDetailsBtn = new Button("Quiz " + i);
            userResultsBox.getChildren().add(resultDetailsBtn);
            resultDetailsBtn.setOnAction(e -> {
                loadSingleResultScene(quizResult);
                root.setCenter(singleResultBox);
            });
            i++;
        }
    }

    public void loadSingleResultScene(QuizResult quizResult) {
        Button returnBack = new Button("Return to Result List");
        singleResultBox = new VBox();
        singleResultBox.setPadding(new Insets(20, 20, 20, 20));
        singleResultBox.setSpacing(10);
        percentageLabel = new Label("Your result in this quiz was: " + quizResult.getPercentage());
        ScrollPane scrollPane = scrollPaneSetup(quizResult.getResultList());

        returnBack.setOnAction(e -> {
            loadResultsScene();
            root.setCenter(userResultsBox);
        });

        singleResultBox.getChildren().addAll(percentageLabel, scrollPane, returnBack);
    }
}