package com.paliari;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.Collections;
import java.util.List;

/**
 * Created by neves on 20/10/14.
 */
public class ArraySum {
    protected int length = 0;
    protected int[] somas;
    protected int[] input;
    protected int[] output;

    public ArraySum(int[] input) {
        Arrays.sort(input);
        length = input.length;
        this.input = new int[length];
        for (int i = 0; i < length; i++) {
            this.input[i] = input[length-i-1];
        }
        somas = new int[length];
        output = new int[length];

        int soma = 0;
        for (int i = 0; i < length; i++) {
            soma += input[i];
            somas[length-i-1] = soma;
        }
    }

    public boolean find(int total, int i) {
        if (i >= length) return false;
        if (total > somas[i]) return false;
        int current = input[i];
        if (total == current) {
            output[i] = total;
            return true;
        }
        if (find(total, i+1)) {
            return true;
        }
        output[i] = current;
        if (find(total-current, i+1)) {
            return true;
        }
        output[i] = 0;
        return false;
    }

    public boolean find(int total) {
        return find(total, 0);
    }

    public Integer[] result() {
        List<Integer> list = new ArrayList<Integer>();
        for (int i : output) {
            if (i > 0) {
                list.add(i);
            }
        }
        return list.toArray(new Integer[list.size()]);
    }
}

