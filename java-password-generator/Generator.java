import javax.swing.JOptionPane;

public class Generator{
    public static void main(String[] args) {
        String str = new String();
        str = JOptionPane.showInputDialog(null, "Enter the string to generate passwords: ");
        System.out.println(str+" is the string you entered");
    }
}