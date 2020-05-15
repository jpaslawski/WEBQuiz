package pl.jp.models;

public class Quiz {

    private String name;
    private String info;
    private String fileName;
    private boolean isPublic;

    public Quiz(String name, String info, String fileName, boolean isPublic) {
        this.name = name;
        this.info = info;
        this.fileName = fileName;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getInfo() {
        return info;
    }

    public void setInfo(String info) {
        this.info = info;
    }

    public String getFileName() {
        return fileName;
    }

    public void setFileName(String fileName) {
        this.fileName = fileName;
    }

    public boolean isPublic() {
        return isPublic;
    }

    public void setPublic(boolean aPublic) {
        isPublic = aPublic;
    }
}
