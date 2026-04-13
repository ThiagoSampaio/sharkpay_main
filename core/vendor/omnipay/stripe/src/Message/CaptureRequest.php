 );
  }

  @override
  bool operator ==(Object other) {
    if (identical(this, other)) {
      return true;
    }
    return other is RelativeRect &&
        other.left == left &&
        other.top == top &&
        other.right == right &&
        other.bottom == bottom;
  }

  @override
  int get hashCode => Object.hash(left, top, right, bottom);

  @override
  String toString() =>
      'RelativeRect.fromLTRB(${left.toStringAsFixed(1)}, ${top.toStringAsFixed(1)}, ${right.toStringAsFixed(1)}, ${bottom.toStringAsFixed(1)})';
}

/// Parent data for use with [RenderStack].
class StackParentData extends ContainerBoxParentData<RenderBox> {
  /// The distance by which the child's top edge is inset from the top of the stack.
  double? top;

  /// The distance by which the child's right edge is inset from the right of the stack.
  double? right;

  /// The distance by which the child's bottom edge is inset from the bottom of the stack.
  double? bottom;

  /// The distance by which the child's left edge is inset from the left of the stack.
  double? left;

  /// The child's width.
  ///
  /// Ignored if both left and right are non-null.
  double? width;

  /// The ch