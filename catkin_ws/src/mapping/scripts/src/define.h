// define byte send pc to stm
#define num_byte_pc_stm 86
#define num_byte_stm_pc 86

#define byte_start0 0xff
#define byte_start1 0xee
#define byte_start2 0xdd 

#define byte_end0 0xdd
#define byte_end1 0xee
#define byte_end2 0xff

#define byte_uart_time_out 0xcc

// frame byte pc to stm
// motor1
#define motor1_enable       3
#define motor1_stop         4
#define motor1_cw_cww       5
#define motor1_set_speedH   6
#define motor1_set_speedL   7
#define motor1_set_torqueH  8
#define motor1_set_torqueL  9
#define motor1_reset_error  10
#define motor1_break        11
// motor2 
#define motor2_enable       18
#define motor2_stop         19
#define motor2_cw_cww       20
#define motor2_set_speedH   21
#define motor2_set_speedL   22
#define motor2_set_torqueH  23
#define motor2_set_torqueL  24
#define motor2_reset_error  25
#define motor2_break        26
// IO system
#define robot_shutdow       33
#define robot_led_left      35
#define robot_led_right     36
#define robot_led_back      37
#define robot_color_red     38
#define robot_color_green   39
#define robot_color_blue    40
#define robot_led_front     41
// liff options mvp
#define robot_liff_pwm      42
#define robot_liff_cylinder 43
// hook options mvp
#define robot_hook_         44
// IO user
#define num_out_put_user    12
#define robot_io_user_out0  57
#define robot_io_user_out1  58
#define robot_io_user_out2  59
#define robot_io_user_out3  60
#define robot_io_user_out4  61
#define robot_io_user_out5  62
#define robot_io_user_out6  63
#define robot_io_user_out7  64
#define robot_io_user_out8  65
#define robot_io_user_out9  66
#define robot_io_user_out10 67
#define robot_io_user_out11 68
//
