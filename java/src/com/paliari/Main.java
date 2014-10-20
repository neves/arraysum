package com.paliari;

public class Main {

    public static void main(String[] args) {
	// write your code here
        int[] input = new int[args.length-1];
        int expected = Integer.parseInt(args[0]);
        for (int i = 1; i < args.length; i++) {
            input[i-1] = Integer.parseInt(args[i]);
        }

        ArraySum ar = new ArraySum(input);
        long before = System.nanoTime();
        ar.find(expected);
        System.out.println((System.nanoTime() - before)/1000.0/1000.0/1000.0);
        for (int i : ar.result()) {
            System.out.print(i);
            System.out.print(" ");
        }
    }
}
