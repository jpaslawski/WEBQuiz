package pl.jp.models;

public class SingleResult {
    private String question;
    private String[] answers;
    private int[] correctAnswers;
    private int[] userAnswers;

    public SingleResult() {

    }

    public SingleResult(String question, String[] answers, int[] correctAnswers, int[] userAnswers) {
        this.question = question;
        this.answers = answers;
        this.correctAnswers = correctAnswers;
        this.userAnswers = userAnswers;
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

    public int[] getUserAnswers() {
        return userAnswers;
    }

    public void setUserAnswers(int[] userAnswers) {
        this.userAnswers = userAnswers;
    }
}
