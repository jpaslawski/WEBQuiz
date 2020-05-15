package pl.jp.models;

public class Question {

    private String question;

    private String[] answers;

    private int[] correctAnswers;

    private String attachedFile;

    public Question() {

    }

    public Question(String question, String[] answers, int[] correctAnswers, String attachedFile) {
        this.question = question;
        this.answers = answers;
        this.correctAnswers = correctAnswers;
        this.attachedFile = attachedFile;
    }

    public String getQuestion() {
        return question;
    }

    public void setQuestion(String question) {
        this.question = question;
    }

    public String[] getAnswers() {
        return answers;
    }

    public void setAnswers(String[] answers) {
        this.answers = answers;
    }

    public int[] getCorrectAnswers() {
        return correctAnswers;
    }

    public void setCorrectAnswers(int[] correctAnswers) {
        this.correctAnswers = correctAnswers;
    }

    public String getAttachedFile() {
        return attachedFile;
    }

    public void setAttachedFile(String attachedFile) {
        this.attachedFile = attachedFile;
    }
}
