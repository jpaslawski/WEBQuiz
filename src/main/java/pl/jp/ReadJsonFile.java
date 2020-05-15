package pl.jp;

import com.google.gson.Gson;
import com.google.gson.reflect.TypeToken;
import pl.jp.models.Question;
import pl.jp.models.Quiz;
import pl.jp.models.QuizResult;
import pl.jp.models.User;

import java.io.*;
import java.lang.reflect.Type;
import java.util.ArrayList;
import java.util.LinkedList;
import java.util.List;

public class ReadJsonFile {

    private List<User> users;
    private List<Question> questions;
    private List<Quiz> quizzes;
    private List<QuizResult> quizResults;

    public List<User> getUsers() {
        try {
            //InputStream inputStream = pl.jp.JavaFXQuiz.class.getResourceAsStream("/userList.json");
            //InputStreamReader inputReader = new InputStreamReader(inputStream);
            FileReader inputReader = new FileReader("userList.json");
            Type listType = new TypeToken<ArrayList<User>>(){}.getType();
            users = new Gson().fromJson(inputReader, listType);

            inputReader.close();
        }
        catch (FileNotFoundException e) {
            System.err.println("File does not exist");
        }
        catch (IOException e) {  System.err.println("An error occurred while writing to the file."); }

        return users;
    }

    public User getUser(String email) {
        List<User> userList = getUsers();
        for (User user : userList) {
            if(email.equals(user.getEmail())) {
                return user;
            }
        }
        return null;
    }

    public void addNewUser(List<User> users) {
        try {
            /*FileWriter writer = new FileWriter(pl.jp.JavaFXQuiz.class.getClassLoader()
                    .getResource("userList.json").getPath()
                    .replaceAll("%20", " "));*/
            FileWriter writer = new FileWriter("userList.json");
            Gson gson = new Gson();
            gson.toJson(users, writer);
            writer.flush();
            writer.close();
        }
        catch (FileNotFoundException e) { System.err.println("File does not exist"); }
        catch (IOException e) {  System.err.println("An error occurred while writing to the file."); }
    }

    public List<Question> getQuestions(String fileName) {
        try {
            //InputStream inputStream = pl.jp.JavaFXQuiz.class.getResourceAsStream("/" + fileName);
            //InputStreamReader inputReader = new InputStreamReader(inputStream);
            FileReader inputReader = new FileReader(fileName);
            Type listType = new TypeToken<ArrayList<Question>>(){}.getType();
            questions = new Gson().fromJson(inputReader, listType);
            inputReader.close();
        }
        catch (Exception e) {return null;}

        return questions;
    }

    public void addNewQuestion(List<Question> questions, String fileName) {
    try {
        /*PrintWriter writer =
                new PrintWriter(
                        new File(this.getClass().getResource(fileName).getPath()));*/
        FileWriter writer = new FileWriter(fileName);
        Gson gson = new Gson();
        gson.toJson(questions, writer);
        writer.flush();
        writer.close();
    }
    catch (FileNotFoundException e) { System.err.println("File does not exist"); }
    catch (IOException e) { e.printStackTrace(); }
    }

    public List<Quiz> getQuizzes() {
        try {
            //InputStream inputStream = pl.jp.JavaFXQuiz.class.getResourceAsStream("/quizList.json");
            //InputStreamReader inputReader = new InputStreamReader(inputStream);
            FileReader inputReader = new FileReader("quizList.json");
            Type listType = new TypeToken<ArrayList<Quiz>>(){}.getType();
            quizzes = new Gson().fromJson(inputReader, listType);

            inputReader.close();
        }
        catch (FileNotFoundException e) { System.err.println("File does not exist"); }
        catch (IOException e) {  System.err.println("An error occurred while writing to the file."); }

        return quizzes;
    }

    public void addNewQuiz(List<Quiz> quizzes) {
        try {
            /*FileWriter writer = new FileWriter(pl.jp.JavaFXQuiz.class.getClassLoader()
                    .getResource("quizList.json").getPath()
                    .replaceAll("%20", " "));*/
            FileWriter writer = new FileWriter("quizList.json");
            Gson gson = new Gson();
            gson.toJson(quizzes, writer);
            writer.flush();
            writer.close();
        }
        catch (FileNotFoundException e) { System.err.println("File does not exist"); }
        catch (IOException e) {  System.err.println("An error occurred while writing to the file."); }
    }

    public List<QuizResult> getUserResults(String email) {
        try {
            FileReader reader = new FileReader(email + ".json");
            Type listType = new TypeToken<ArrayList<QuizResult>>(){}.getType();
            quizResults = new Gson().fromJson(reader, listType);

            reader.close();
        } catch (FileNotFoundException e) {
            System.out.println("There is no file with the given name! Creating file....");
            File file = new File(email + ".json");
            try {
                file.createNewFile();
            } catch (IOException ex) {
                System.out.println("Unable to create new file");
            }
            try {
                FileOutputStream oFile = new FileOutputStream(file, false);
                return null;
            } catch (FileNotFoundException ex) {
                ex.printStackTrace();
            }
        } catch (IOException e) {
            e.printStackTrace();
        }

        return quizResults;
    }

    public void saveResults(QuizResult quizResult, String email) {
        List<QuizResult> quizResults = getUserResults(email);
        if (quizResults == null) {
            List<QuizResult> newList = new LinkedList<QuizResult>();
            newList.add(quizResult);
            try {
                FileWriter writer = new FileWriter(email + ".json");
                new Gson().toJson(newList, writer);
                writer.flush();
                writer.close();
            } catch (IOException e) {
                System.err.println("Unable to save results!");
            }
        } else {
            quizResults.add(quizResult);
            try {
                FileWriter writer = new FileWriter(email + ".json");
                new Gson().toJson(quizResults, writer);
                writer.flush();
                writer.close();
            } catch (IOException e) {
                System.err.println("Unable to save results!");
            }
        }
    }
}
