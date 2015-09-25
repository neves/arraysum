#include <iostream>

using namespace std;

int read_input(int *input, int length = 0) {
    int n, r;
    cin >> n;
    if (n > 0) {
        r = read_input(input, length + 1);
        input[length] = n;
        return r;
    } else {
        input = (int *)malloc(length * sizeof(int));
        return length;
    }
}

class ArraySum {
    int* input;
    int* output;
    int* somas;
    int length;
public:
    int count = 0;
    ArraySum(int length, int input[]) {
        this->length = length;
        this->input = input;
        std::sort(this->input, this->input + this->length, std::greater<int>());
        this->output = (int *)malloc(this->length * sizeof(int));
        this->somas = (int *)malloc(this->length * sizeof(int));

        for (int i = 0; i < this->length; i++) {
            this->output[i] = 0;
        }

        int sums = 0;
        for (int i = this->length-1; i >= 0; i--) {
            sums += this->input[i];
            this->somas[i] = sums;
        }
    }

    bool find(int total, int i = 0) {
        this->count++;
        if (i >= this->length) return false;
        if (total > this->somas[i]) return false;

        int current = this->input[i];

        // achei
        if (total == current) {
            this->output[i] = total;
            return true;
        }

        // ignora
        if (total < current) {
            return this->find(total, i+1);
        } else { // if (total > current) {
            if ( this->find(total, i+1) ) {
                return true;
            } else {
                this->output[i] = current;
                int rest = total - current;
                if ( this->find(rest, i+1) ) {
                    return true;
                } else {
                    this->output[i] = 0;
                    return false;
                }
            }
        }
    }

    void print_output() {
        int n;
        for (int i = 0; i < this->length; i++) {
            n = this->output[i];
            if (n > 0) {
                cout << n << ' ';
            }
        }
        cout << endl;
    }

    int sum() {
        int s = 0;
        for (int i = 0; i < this->length; i++) {
            s += this->output[i];
        }
        return s;
    }
};

int main(int argc, char* argv[]) {
    //const int LENGTH  = 45;
    //int input[LENGTH] = {16185,11400,10800,10800,8100,2970,2700,2355,1800,1785,1785,1739,1725,1425,1350,1350,1350,1350,1350,1350,1350,1050,1050,990,990,990,990,990,869,869,869,869,600,600,540,450,450,450,450,434,434,434,434,390,375};
    //int expected = 90795;

    int size = argc - 2;
    int expected;
    int *input;
    input = (int *)malloc(size * sizeof(int));

    expected = atoi(argv[1]);

    for (int i = 0; i < size; i++) {
        input[i] = atoi(argv[i+2]);
    }

    ArraySum sum(size, input);

    clock_t begin = clock();
    sum.find(expected);
    clock_t end = clock();

    unsigned long elapsed_clocks = end - begin;
    double seconds = double(end - begin) / CLOCKS_PER_SEC;
    printf("%f\n", seconds);
    //cout.precision(15);
    //cout << seconds << endl;
    //cout << begin << endl;
    //cout << end << endl;
    //cout << CLOCKS_PER_SEC << endl;
    //cout << elapsed_secs << endl;
    sum.print_output();
    //cout << sum.count << endl;
    //cout << endl << sum.sum() << " = " << expected << endl;

    return 0;
}
